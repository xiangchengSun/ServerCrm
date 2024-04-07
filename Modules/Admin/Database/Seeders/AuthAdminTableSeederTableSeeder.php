<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthAdminTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('auth_admin')->insert([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'is_super' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
