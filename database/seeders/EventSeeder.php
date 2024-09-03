<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'title' => 'Evento 1',
                'description' => 'Descripción del evento 1',
                'start' => '2024-07-25 10:00:00',
                'end' => '2024-07-25 12:00:00',
            ],
            [
                'title' => 'Evento 2',
                'description' => 'Descripción del evento 2',
                'start' => '2024-07-26 14:00:00',
                'end' => '2024-07-26 16:00:00',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
