<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
        	[
	            'type' => 'admin',
	            'label' => 'Maintenance Mode',
	            'param' => 'maintenance_mode',
	            'value' => 'no',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,yes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Maintenance Message',
	            'param' => 'maintenance_msg',
	            'value' => 'Website under maintenance',
	            'field' => 'textfield',
	            'note' => '',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Maintenance Retry',
	            'param' => 'maintenance_retry',
	            'value' => '60',
	            'field' => 'number',
	            'note' => '',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Maintenance Allow',
	            'param' => 'maintenance_allow',
	            'value' => '127.0.0.1',
	            'field' => 'textfield',
	            'note' => 'separate IP by commas',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Google Analytics Mode',
	            'param' => 'ga_mode',
	            'value' => 'no',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,yes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Google Analytics Code',
	            'param' => 'ga_code',
	            'value' => '',
	            'field' => 'textarea',
	            'note' => '',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Tracking Page',
	            'param' => 'ga_track',
	            'value' => 'website',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'website,admin,both',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Announcement Mode',
	            'param' => 'announce_mode',
	            'value' => 'no',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,yes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Announcement Message',
	            'param' => 'announce_msg',
	            'value' => 'Website under maintenance',
	            'field' => 'textfield',
	            'note' => '',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Announcement Mood',
	            'param' => 'announce_mood',
	            'value' => 'message',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'message,warning,danger',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Announcement Start',
	            'param' => 'announce_start',
	            'value' => '',
	            'field' => 'datetime',
	            'note' => '',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Announcement End',
	            'param' => 'announce_end',
	            'value' => '',
	            'field' => 'datetime',
	            'note' => '',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Password must contain at least 1 number',
	            'param' => 'password_number',
	            'value' => 'yes',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,yes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Password must contain at least 1 character',
	            'param' => 'password_character',
	            'value' => 'yes',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,yes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Password must contain at least 1 uppercase',
	            'param' => 'password_uppercase',
	            'value' => 'no',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,yes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Password must contain at least 1 special character',
	            'param' => 'password_specialcharacter',
	            'value' => 'no',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,yes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Minimum Password',
	            'param' => 'password_min',
	            'value' => '5',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => '5,6,7,8',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Maximum Password',
	            'param' => 'password_max',
	            'value' => '12',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => '12,13,14,15',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Password History',
	            'param' => 'password_history',
	            'value' => 'no',
	            'field' => 'checkbox',
	            'note' => '',
	            'options' => 'no,1,2,3,4,5',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Cold Down Period',
	            'param' => 'password_colddown',
	            'value' => 'no',
	            'field' => 'checkbox',
	            'note' => '*in hours',
	            'options' => 'no,12,24,36,48,72',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ],[
	            'type' => 'admin',
	            'label' => 'Application Name',
	            'param' => 'header_title',
	            'value' => 'Anggota',
	            'field' => 'textfield',
	            'note' => '',
	            'options' => '',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ]
        ]);
    }
}
