<?php
  
use Illuminate\Database\Seeder;
use App\User;
   
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminadmin'),
            'level' =>'admin',
        ]); 
        User::create([
            'name' => 'Warehouse',
            'email' => 'warehouse@gmail.com',
            'password' => bcrypt('adminadmin'),
            'level' =>'warehouse',
        ]); 
        User::create([
            'name' => 'Procurement',
            'email' => 'procurement@gmail.com',
            'password' => bcrypt('adminadmin'),
            'level' =>'procurement',
        ]); 
        User::create([
            'name' => 'Accounting',
            'email' => 'accounting@gmail.com',
            'password' => bcrypt('adminadmin'),
            'level' =>'accounting',
        ]); 
        User::create([
            'name' => 'United Tractors',
            'id_vendor' => 2011000155,            
            'email' => 'unitedtractors@gmail.com',
            'npwp' => '4444444444444444',
            'password' => bcrypt('adminadmin'),
            'level' =>'vendor',
        ]); 
    }
}