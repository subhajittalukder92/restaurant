<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['id' => 1],
            [
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'mobile' => '1000000001',
            'role_id' => 1,
            'email_verified_at' => null,
            'password' =>  Hash::make('12345'),
        ]);

        User::updateOrCreate(
            ['id' => 2],
            [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'mobile' => '1000000002',
            'role_id' => 2,
            'restaurant_id' => 1,
            'email_verified_at' => null,
            'password' =>  Hash::make('12345'),
        ]);

        // Manager
        User::updateOrCreate(
            ['id' => 3],
            [
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'mobile' => '1000000003',
            'role_id' => 3,
            'email_verified_at' => null,
            'password' =>  Hash::make('12345'),
        ]);

        // Delivery Boy
        User::updateOrCreate(
            ['id' => 4],
            [
            'name' => 'Delivery Boy',
            'mobile' => '1000000004',
            'role_id' => 4,
            'email_verified_at' => null,
            'password' =>  Hash::make('12345'),
        ]);
    }
}
