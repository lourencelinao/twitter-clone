<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Lourence Linao',
            // 'description' => 'wtf',
            'email' => 'lourencelinao13@gmail.com',
            'password' => bcrypt('test'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'name' => 'test',
            // 'description' => 'wtf',
            'email' => 'test@test.com',
            'password' => bcrypt('test'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // $faker = Factory::create();
        // for($i = 0; $i < 5; $i++){
        //     App\User::create([
        //         'name' => $faker->name(),
        //         'email' => $faker->email,
        //         'password' => bcrypt($faker->password()),
        //     ]);
        // }

        $users = factory(App\User::class, 10)->create();
        for($i = 2; $i <= 10; $i++){
            for($x = 0; $x < 5; $x++){
                $tweet = factory(App\Tweet::class)->create(['user_id' => $i]);
                $tweet->timeline()->create(['user_id' => $tweet->user_id, 'created_at' => $tweet->created_at]);
            }
        }
    }
}
