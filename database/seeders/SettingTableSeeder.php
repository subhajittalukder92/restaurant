<?php
namespace Database\Seeders;


use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        Setting::updateOrCreate([ 'id' => 1 ], [
            'restaurant_id' => '1',
            'key' => 'key_id',
            'value' => 'rzp_test_LcMDQS1fWMI26q',
          
        ]);
        Setting::updateOrCreate([ 'id' => 2 ], [
            'restaurant_id' => '1',
            'key' => 'key_secret',
            'value' => 'Xa1wKmcn6tkwZ8EgxxbxZkxw',
          
        ]);
        Setting::updateOrCreate([ 'id' => 3 ], [
            'restaurant_id' => '1',
            'key' => 'online_payment',
            'value' => 1,
          
        ]);
        Setting::updateOrCreate([ 'id' => 4 ], [
            'restaurant_id' => '1',
            'key' => 'cash_payment',
            'value' => 0,
          
        ]);
        Setting::updateOrCreate([ 'id' => 5 ], [
            'restaurant_id' => '1',
            'key' => 'reward_coin_value',
            'value' => 1,
          
        ]);
        Setting::updateOrCreate([ 'id' => 6 ], [
            'restaurant_id' => '1',
            'key' => 'minimum_coin_value_to_redeem',
            'value' => 100,
          
        ]);
        Setting::updateOrCreate([ 'id' => 7 ], [
            'restaurant_id' => '1',
            'key' => 'minimum_amount_for_free_delivery',
            'value' => 0,
          
        ]);
        Setting::updateOrCreate([ 'id' => 8 ], [
            'restaurant_id' => '1',
            'key' => 'delivery_charge',
            'value' => 50,
          
        ]);

       

      
    }
}
