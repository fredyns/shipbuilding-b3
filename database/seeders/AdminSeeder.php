<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // admin

        $user = User::create([
            'name' => 'Fredy',
            'email' => 'dm@fredyns.id',
            'password' => '$2y$10$MzUsuh0fQuLw2TRgdaeFhug2jsT9egIMg8ze3lUKjy/8E1N5POx..',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole($adminRole);

        $user = User::create([
            'name' => 'IT Marine Services',
            'email' => 'it.mnom@bki.co.id',
            'password' => '$2y$12$jSAMUkSEAV07XkQPzg9kOejslPTG20GBuoWFFe2RWe6pMSJzQ07Dy',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole($adminRole);

        // regular users
        $user = User::create([
            'name' => 'Fredy',
            'email' => 'fredy.ns@gmail.com',
            'password' => '$2y$10$MzUsuh0fQuLw2TRgdaeFhug2jsT9egIMg8ze3lUKjy/8E1N5POx..',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // dev only

        $env = env('APP_ENV');
        if (str_contains($env, 'prod')) return;

        $user = User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $user->assignRole($adminRole);
    }
}
