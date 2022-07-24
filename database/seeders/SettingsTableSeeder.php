<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'site_name',
                'value' => 'Vandemission',
                'description' => NULL,
                'type' => 'Text',
                'is_active' => '1',
                'is_active_at' => '2022-02-13 04:46:53',
                'created_at' => '2022-02-13 04:46:53',
                'updated_at' => '2022-02-13 04:46:53',
            ),
        ));
        
        
    }
}