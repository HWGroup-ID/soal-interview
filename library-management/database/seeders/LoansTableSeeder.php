<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;

class LoansTableSeeder extends Seeder
{
    public function run()
    {
        // Generate 30 loans with random data using the factory
        Loan::factory()->count(30)->create();
    }
}

