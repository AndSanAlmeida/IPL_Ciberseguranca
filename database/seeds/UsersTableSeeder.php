<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $numberOfUsers = 10;
    private $totalForumPosts = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pt_PT');

        DB::table('users')->insert($this->fakeUser($faker, true));

        for ($i = 0; $i < $this->numberOfUsers; ++$i) {
            DB::table('users')->insert($this->fakeUser($faker, false));
        }
    }

    private function fakeUser(Faker\Generator $faker, $type)
    {
        static $password;
        $createdAt = Carbon\Carbon::now()->subDays(30);
        $updatedAt = $faker->dateTimeBetween($createdAt);

        $username = $type ? 'admin' : $faker->unique()->userName;
        $email = $type ? 'admin@mail.test' : $faker->unique()->safeEmail;
        
        return [
            'name' => $faker->name,
            'email' => $email,
            'password' => $password ?: $password = bcrypt('secret'),
            'username' => $username,
            'type' => $type,
            'blocked' => false,
            'reason_blocked' => null,
            'reason_reactivated' => null,
            'activated' => true,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
