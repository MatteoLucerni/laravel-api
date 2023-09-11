<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
            ['label' => 'HTML', 'color' => 'danger'],
            ['label' => 'CSS', 'color' => 'info'],
            ['label' => 'ES6', 'color' => 'warning'],
            ['label' => 'BootStrap', 'color' => 'dark'],
            ['label' => 'PHP', 'color' => 'primary'],
            ['label' => 'SQL', 'color' => 'secondary'],
            ['label' => 'Laravel', 'color' => 'danger'],
            ['label' => 'VueJs', 'color' => 'success'],
        ];

        foreach ($technologies as $technology) {
            $newTechnology = new Technology();
            $newTechnology->label = $technology['label'];
            $newTechnology->color = $technology['color'];
            $newTechnology->save();
        }
    }
}
