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
            'email' => 'lourencelinao13@gmail.com',
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

        $users = factory(App\User::class, 50)->create();
        for($i = 2; $i <= 50; $i++){
            for($x = 0; $x < 5; $x++){
                factory(App\Tweet::class)->create(['user_id' => $i]);
            }
        }
    }
}
