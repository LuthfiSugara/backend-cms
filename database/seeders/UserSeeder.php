<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->name = 'New Admin';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('rahasia');
        $user->role = 'admin';
        $user->created_at = round(microtime(true));
        $user->updated_at = round(microtime(true));
        $user->save();

        $user->assignRole('admin');
    }
}
