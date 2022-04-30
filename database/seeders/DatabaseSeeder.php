<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
            $n = 400000;
            while($n>0){
                try{
                    $image = Image::factory()->create();
                    $user = User::factory()->create();
                    $user->image_id = $image->id;
                    $user->save();
                    $n--;
                }catch(Exception $e){
                    continue;
                }
            }



    }
}
