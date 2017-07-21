<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'uid'          => '12345',
            'name'         => 'admin',
            'surname'      => 'admin',
            'email'        => 'admin@sherna.cz',
            'block_number' => 6
        ]);
    }
}
