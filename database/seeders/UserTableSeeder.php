<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array(
            [
                'name' => 'Ismael',
                'email' => 'ismael@pusherchatapp.com',
                'portfolio' => 'team1',
                'team' => 'kelsea',
                'position' => 'RM'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@pusherchatapp.com',
                'portfolio' => 'team1',
                'team' => 'kelsea',
                'position' => 'TL'
            ],
            [
                'name' => 'Kelsea',
                'email' => 'kelsea@pusherchatapp.com',
                'portfolio' => 'team1',
                'team' => 'kelsea',
                'position' => 'TL'
            ],
            [
                'name' => 'Anne',
                'email' => 'anne@pusherchatapp.com',
                'portfolio' => 'team2',
                'team' => 'jess',
                'position' => 'RM'
            ],
            [
                'name' => 'Nancy',
                'email' => 'nancy@pusherchatapp.com',
                'portfolio' => 'team2',
                'team' => 'jess',
                'position' => 'RM'
            ]
        );

        array_map(function($user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('S@mpleP@ssword1337'),
                'api_token' => Str::random(60),
                'portfolio' => $user['portfolio'],
                'team' => $user['team'],
                'position' => $user['position'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }, $users);
    }
}
