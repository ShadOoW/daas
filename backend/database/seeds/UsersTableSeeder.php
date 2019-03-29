<?php
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 users using the user factory
        factory(App\User::class, 10)->create();

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@daas.com',
            'password' => app('hash')->make('12345'),
        ]);
    }
}
