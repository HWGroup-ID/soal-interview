<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "book_id",
        "borrowed_at",
        "returned_at"
    ];

    public function book() // Define the relationship with the Book model
    {
        return $this->belongsTo(Book::class);
    }
}
