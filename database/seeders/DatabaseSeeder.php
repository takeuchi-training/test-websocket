<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Department;
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
        Department::create(['name' => 'IT']);
        Department::create(['name' => 'Design']);
        Department::create(['name' => 'BIM']);

        User::create([
            'name' => 'Truong',
            'email' => 'giangnhattruong@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'department_id' => 1
        ]);
        User::create([
            'name' => 'Test1',
            'email' => 'test1@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'department_id' => 1
        ]);
        User::create([
            'name' => 'Test2',
            'email' => 'test2@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'department_id' => 2
        ]);
        User::create([
            'name' => 'Test3',
            'email' => 'test3@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'department_id' => 3
        ]);
        User::create([
            'name' => 'AdminIT',
            'email' => 'adminit@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'is_admin' => 1,
            'department_id' => 1
        ]);
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'is_admin' => 1,
            'department_id' => 1
        ]);
        User::create([
            'name' => 'Admin2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'is_admin' => 1,
            'department_id' => 2
        ]);
        User::create([
            'name' => 'Admin3',
            'email' => 'admin3@gmail.com',
            'password' => bcrypt('Nhattruong@1'),
            'is_admin' => 1,
            'department_id' => 3
        ]);

        Application::factory(9)->create();
        Room::factory(7)->create();
        RoomUser::factory(60)->create();
        Message::factory(90)->create();
    }
}
