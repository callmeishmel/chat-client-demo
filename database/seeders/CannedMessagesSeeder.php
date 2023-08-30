<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class CannedMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = array(
            [
                'message' => 'Can I get your help, please?',
                'possible_responses' => '["Yes", "No","In a moment"]'
            ],
            [   'message' => 'Are you available?',
                'possible_responses' => '["Yes", "No","In a moment"]'
            ],
            [
                'message' => 'I would love to say something to you real quick!',
                'possible_responses' => '["Ok","I\'ll be right there","I\'ll can\'t leave my seat"]'
            ],
            [
                'message' => 'Can we go chat? I need some feedback!',
                'possible_responses' => '["Yes", "No", "After this call"]'
            ],
            [
                'message' => 'Will you come here, please?',
                'possible_responses' => '["Yes", "No", "I can\'t leave my seat", "In a moment"]'
            ]
        );

        array_map(function($msg) {
            DB::table('canned_messages')->insert([
                'created_by' => 0,
                'updated_by' => 0,
                'message' => $msg['message'],
                'possible_responses' => $msg['possible_responses'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }, $messages);
    }
}
