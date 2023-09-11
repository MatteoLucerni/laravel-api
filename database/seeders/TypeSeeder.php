<?php

namespace Database\Seeders;

use App\Models\Type;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $labels = ['FrontEnd', 'BackEnd', 'FullStack', 'UI/UX', 'Design'];

        foreach ($labels as $label) {
            $type = new Type();
            $type->label = $label;
            $type->color = $faker->hexColor();
            $type->save();
        }
    }
}
