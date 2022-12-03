<?php
namespace Database\Seeders;


use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin role
        Restaurant::updateOrCreate([ 'id' => 1 ], [
            'name' => 'Demo restaurant',
            'slug' => Str::slug('Demo restaurant'),
            'phone' => 123456789,
            'address' => 'MM Road',
            'city' => 'City',
            'state' => 'West Bengal',
            'country' => 'India',
            'zip' => '452252',
        ]);

      
      
    }
}
