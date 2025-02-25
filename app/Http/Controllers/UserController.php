<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use fredyns\stringcleaner\StringCleaner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', User::class);

        $search = (string)$request->get('search', '');

        if (!$search or $search == 'null') {
            $search = '';
        }

        $users = User::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        $roles = Role::get();

        return view('app.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();
        $validated['two_factor_secret'] = StringCleaner::forRTF(
            $validated['two_factor_secret']
        );
        $validated['two_factor_recovery_codes'] = StringCleaner::forRTF(
            $validated['two_factor_recovery_codes']
        );
        $validated['profile_photo_path'] = StringCleaner::forRTF(
            $validated['profile_photo_path']
        );

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.show', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user): View
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): View
    {
        $this->authorize('update', $user);

        $roles = Role::get();

        return view('app.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UserUpdateRequest $request,
        User              $user
    ): RedirectResponse
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        $validated['two_factor_secret'] = StringCleaner::forRTF(
            $validated['two_factor_secret']
        );
        $validated['two_factor_recovery_codes'] = StringCleaner::forRTF(
            $validated['two_factor_recovery_codes']
        );
        $validated['profile_photo_path'] = StringCleaner::forRTF(
            $validated['profile_photo_path']
        );

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.show', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
