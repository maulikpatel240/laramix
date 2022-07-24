<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin')->delete();
        
        \DB::table('admin')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'auth_key' => '32cf70b29bb02d38476775af7f4a8f709ffa46169c53222366767a8a771d2706',
                'first_name' => 'Maulik',
                'last_name' => 'Patel',
                'email' => 'maulikpatel240@gmail.com',
                'email_otp' => '',
                'email_verified' => '1',
                'email_verified_at' => '2022-02-02 10:00:00',
                'password' => '$2y$10$pKC5hGchDk.ZjwZEYOaLIeU4ewvUoIDjvrQHiAK5KYL3l7DztwmlS',
                'password_reset_token' => NULL,
                'verification_token' => NULL,
                'phone_number' => '6354800439',
                'phone_number_otp' => '',
                'phone_number_verified' => '1',
                'phone_number_verified_at' => '2022-02-02 10:00:00',
                'profile_photo' => NULL,
                'remember_token' => NULL,
                'is_active' => '1',
                'is_active_at' => '2021-11-19 05:14:19',
                'created_at' => '1979-08-15 17:59:49',
                'updated_at' => '2021-11-19 05:14:19',
            ),
        ));
        
        
    }
}