<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(25)->create()->each(function (User $user) {
            $user->assignRole('Estudiante');
        });
        User::factory()->create([
            'name' => 'Maria Isabel',
            'email' => 'mari@mailinator.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Administrador');
        User::factory()->create([
            'name' => 'Jose Eduardo',
            'email' => 'edu@mailinator.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('Estudiante');
    }
}
