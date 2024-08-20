<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'category_id' => $this->faker->numberBetween(1, 5),
            'available' => $this->faker->boolean(80), // 80% chance of being available
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

