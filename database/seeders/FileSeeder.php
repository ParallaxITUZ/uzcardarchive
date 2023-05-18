<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'login' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
        $admin->attachRole('superadmin');
        File::query()->create([
            'filename' => 'file',
            'path' => 'file',
            'extension' => 'pdf',
            'type' => 'doc',
            'size' => '2048',
            'user_id' => $admin->id
        ]);
    }
}
