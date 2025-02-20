<?php


use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Actions\Fortify\CreateNewUser;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $bearerToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearerToken);
        if ($token && !static::isTokenExpired($token->expires_at)) {
            return response()->json([
                'token' => $bearerToken,
                'message' => "Already logged in.",
            ]);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        $user = User::whereEmail($request->email)->firstOrFail();

        $token = $user->createToken('auth-token');

        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $user,
        ]);
    }

    private static function isTokenExpired($expiresAt)
    {
        if (empty($expiresAt)) {
            return false;
        }

        $now = new DateTime();
        return $expiresAt <= $now;
    }

    public function status(Request $request)
    {
        $user = $request->user('sanctum');
        $menus = [];
        $links = [];

        if (Gate::forUser($user)->allows('view-any', User::class)) {
            $menus['users'] = [
                "label" => "Users",
                "url" => route('api.users.index'),
            ];
        }

        if ($user) {
            $links['profile'] = [
                "label" => "Profile",
                "url" => route('api.user'),
            ];
            $links['logout'] = [
                "label" => "Logout",
                "url" => route('api.logout'),
            ];
        } else {
            $links['login'] = [
                "label" => "Login",
                "url" => route('api.login'),
            ];
        }

        return [
            'token' => $request->bearerToken(),
            'message' => $user ? "Authenticated." : "Unauthenticated.",
            'user' => $user,
            'menus' => $menus,
            'links' => $links,
        ];
    }

    public function registration(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearerToken);
        if ($token && !static::isTokenExpired($token->expires_at)) {
            return response()->json([
                'token' => $bearerToken,
                'message' => "Registration only allowed for guest.",
            ]);
        }

        return ['data' => (new CreateNewUser())->create($request->all())];
    }

    public function logout(Request $request)
    {
        $bearerToken = $request->bearerToken();
        $segments = explode('|', $bearerToken);
        $success = $request
            ->user()
            ->tokens()
            ->where('id', $segments[0] ?? 0)
            ->delete();

        return response()->json([
            'message' => $success ? "Logout success" : "Logout failed",
        ]);
    }
}
