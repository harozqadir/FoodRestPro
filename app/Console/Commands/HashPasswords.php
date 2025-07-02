<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HashPasswords extends Command
{
    protected $signature = 'hash:passwords';
    protected $description = 'Hash all unhashed passwords in the users table';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!Hash::check('haroz94', $user->password)) { // Skip already hashed passwords
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Password hashed for user: {$user->email}");
            }
        }

        $this->info('All unhashed passwords have been updated.');
    }
}