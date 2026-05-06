<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'make:admin-user {email=admin@medical.com} {password=12345678}';

    protected $description = 'Create an admin user for Filament';

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if ($user) {
            $this->info("Admin user {$email} already exists.");
            return Command::SUCCESS;
        }

        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("Admin user created: {$email}");
        return Command::SUCCESS;
    }
}