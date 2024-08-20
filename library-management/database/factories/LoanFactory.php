<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    public function definition()
    {
        $borrowedAt = $this->faker->dateTimeBetween('-2 years', 'now');
        $returnedAt = $this->faker->boolean(70) ? $this->faker->dateTimeBetween($borrowedAt, 'now') : null;

        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'borrowed_at' => $borrowedAt,
            'returned_at' => $returnedAt,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

