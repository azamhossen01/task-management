<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'team-leader',
            'developer'
        ];
        foreach($roles as $role){
            Role::create([
                'name' => $role
            ]);
        }
        $admin = User::create([
            'name' => 'Mr. Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'gender' => 'male',
            'role_id' => 1,
            'created_by' => 1
        ]);
        for($i=0;$i <= 10,$i++;){
            Team::create([
                'title' => Str::random(20),
                'members' => rand(2,8),
                'created_by' => 1
            ]);
        }
        // $team_leader_one = User::create([
        //     'name' => 'Mr. Leader One',
        //     'email' => 'leader_one@gmail.com',
        //     'password' => Hash::make('password'),
        //     'gender' => 'male',
        //     'role_id' => 2,
        //     'team_id' => $team_one->id,
        //     'created_by' => 1
        // ]);
        // $team_leader_two = User::create([
        //     'name' => 'Mr. Leader Two',
        //     'email' => 'leader_two@gmail.com',
        //     'password' => Hash::make('password'),
        //     'gender' => 'male',
        //     'role_id' => 2,
        //     'team_id' => $team_two->id,
        //     'created_by' => 1
        // ]);
    }
}
