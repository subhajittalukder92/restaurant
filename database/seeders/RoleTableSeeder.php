<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin role
        Role::updateOrCreate([ 'id' => 1 ], [
            'name' => 'super_admin',
            'display_name' => 'Super Admin',
            'description' => 'Access to everything',
        ]);

        // Create admin role
        Role::updateOrCreate([ 'id' => 2 ], [
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Access limited for admin',
        ]);

        // Create manager role
        Role::updateOrCreate([ 'id' => 3 ], [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'Access limited to manager',
        ]);

        // Create delivery boy role
        Role::updateOrCreate([ 'id' => 4 ], [
            'name' => 'delivery_boy',
            'display_name' => 'Delivery Boy',
            'description' => 'Access limited to devlivery',
        ]);

        // Create Customer role
        Role::updateOrCreate([ 'id' => 5 ], [
            'name' => 'customer',
            'display_name' => 'Customer',
            'description' => 'Access limited to customer',
        ]);

      
    }
}
