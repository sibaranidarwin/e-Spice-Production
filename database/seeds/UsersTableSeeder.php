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
        ],
        [
            'name' => 'Warehouse',
            'email' => 'warehouse@gmail.com',
            'password' => bcrypt('adminadmin'),
            'level' =>'warehouse',
        ]); 
    }
}