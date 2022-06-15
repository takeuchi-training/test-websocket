<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Room;
use App\Models\RoomUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Truong',
            'email' => 'giangnhattruong@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
        ]);
        User::create([
            'name' => 'Test1',
            'email' => 'test1@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
        ]);
        User::create([
            'name' => 'Test2',
            'email' => 'test2@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
        ]);
        User::create([
            'name' => 'Test3',
            'email' => 'test3@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
        ]);
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
        ]);
        User::create([
            'name' => 'Admin2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
        ]);
        User::create([
            'name' => 'Admin3',
            'email' => 'admin3@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
        ]);

        Room::factory(7)->create();
        RoomUser::factory(60)->create();
        Message::factory(90)->create();
    }
}
