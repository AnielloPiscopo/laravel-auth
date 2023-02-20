<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $numOfElements = 100;
        for($i = 0 ; $i<$numOfElements ; $i++){
            $newProject = new Project();
            $newProject->title = $faker->words(5,true);
            $newProject->slug = Str::of($newProject->title)->slug('-');
            $newProject->description = $faker->paragraph(10);
            $newProject->save();
        }
    }
}