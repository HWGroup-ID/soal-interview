<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title", // Ensure title is included for mass assignment
        "author", // Add author if not already present
        "category_id", // Add category_id if not already present
        "available" // Add available if not already present
    ];
}
