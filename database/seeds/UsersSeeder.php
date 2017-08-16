<?php

use App\Models\User;
use Illuminate\Database\Seeder;

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
            'image'        => 'https://static.is.sh.cvut.cz/assets/bag_on_head_white-eaa457debaec8080de4e7f800fa9033b.jpg',
            'email'        => 'admin@sherna.cz',
            'block_number' => 6
        ]);

        \App\Models\Admin::create([
            'uid'  => '12345',
            'role' => 'super_admin'
        ]);
    }
}
