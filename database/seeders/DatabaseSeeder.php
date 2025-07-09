<?php

// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create regular user
        User::create([
            'name' => 'Rifqi Banu Safingi',
            'email' => 'rifqi@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create sample events
        $events = [
            [
                'title' => 'Tech Conference 2025',
                'description' => 'Join us for the biggest tech conference in the region, featuring keynote speakers from the industry and workshops on the latest technologies.',
                'location' => 'Jakarta Convention Center',
                'date' => '2025-06-15',
                'time' => '09:00:00',
                'price' => 250000,
                'capacity' => 500,
            ],
            [
                'title' => 'Digital Marketing Workshop',
                'description' => 'Learn the latest digital marketing strategies and tools to grow your business online from industry experts.',
                'location' => 'Bandung Technology Hub',
                'date' => '2025-07-20',
                'time' => '10:00:00',
                'price' => 150000,
                'capacity' => 100,
            ],
            [
                'title' => 'Community Meetup',
                'description' => 'Meet fellow developers and tech enthusiasts in this monthly community gathering. Share knowledge, network, and have fun!',
                'location' => 'Surabaya Co-working Space',
                'date' => '2025-05-25',
                'time' => '18:30:00',
                'price' => 0,
                'capacity' => 50,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}