<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        // Generate 50 books with random data using the factory
        Book::factory()->count(50)->create();
    }
}

