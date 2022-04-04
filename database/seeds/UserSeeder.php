<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new \App\Models\UserModel;

        if (!$model->where('email', 'admin@admin.com')->exists()) {
            $model->create([
                'role_id'  => 1,
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => '123456',
                'phone'    => '(11) 11111-2222',
            ]);
        }
    }
}
