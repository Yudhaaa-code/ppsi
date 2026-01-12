<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create 
                            {--name= : Nama user}
                            {--email= : Email user}
                            {--password= : Password user}
                            {--role=customer : Role user (customer, developer, admin)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat user baru dengan role tertentu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name') ?: $this->ask('Nama user');
        $email = $this->option('email') ?: $this->ask('Email user');
        $password = $this->option('password') ?: $this->secret('Password user');
        $role = $this->option('role');

        // Validate inputs
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:customer,developer,admin'],
        ]);

        if ($validator->fails()) {
            $this->error('Validasi gagal:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('  - ' . $error);
            }
            return 1;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        $this->info("User berhasil dibuat!");
        $this->table(
            ['ID', 'Nama', 'Email', 'Role'],
            [[$user->id, $user->name, $user->email, $user->role]]
        );

        return 0;
    }
}
