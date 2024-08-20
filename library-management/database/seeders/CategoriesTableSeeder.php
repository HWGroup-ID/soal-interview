<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Science Fiction'],
            ['name' => 'Romance'],
            ['name' => 'Mystery'],
            ['name' => 'Biography'],
            ['name' => 'Fantasy'],
        ];

        DB::table('categories')->insert($categories);
    }
}

