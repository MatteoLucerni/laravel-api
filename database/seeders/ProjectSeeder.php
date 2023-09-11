<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $type_ids = Type::pluck('id')->toArray();

        Storage::makeDirectory('project_images');
        for ($i = 0; $i < 30; $i++) {
            $proj = new Project();
            $proj->type_id = Arr::random($type_ids);
            $proj->title = $faker->text(35);
            $proj->slug = Str::slug($proj->title, '-');
            $proj->image = 'https://t3.ftcdn.net/jpg/02/48/42/64/360_F_248426448_NVKLywWqArG2ADUxDq6QprtIzsF82dMF.jpg';
            // $faker->image(storage_path('app/public/project_images'), 250, 250);
            $proj->description = $faker->paragraph(30, true);
            $proj->n_stars = $faker->randomDigit();
            $proj->is_public = $faker->boolean();
            $proj->save();
        }
    }
}
