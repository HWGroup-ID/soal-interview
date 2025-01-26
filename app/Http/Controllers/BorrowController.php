<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        if ($status == 'borrowed') {
            $borrows = Borrow::when($status, function ($query) {
                return $query->whereNotNull('borrowed_at') // borrowed_at must not be null
                    ->whereNull('returned_at'); // returned_at must be null
            })->get();
        } else {
            $borrows = Borrow::with('book')->get();
        }

        return response()->json([
            'data' => $borrows
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'borrower_name' => 'required|string|max:255'
            ]);

            $existingBorrow = Borrow::where('book_id', $request->book_id)
                ->whereNotNull('borrowed_at')
                ->whereNull('returned_at')
                ->first();

            if ($existingBorrow) {
                return response()->json([
                    'message' => 'This book is already borrowed and has not been returned yet.'
                ], 400);
            }

            $borrow = Borrow::create($request->all());

            return response()->json([
                'data' => $borrow,
                'message' => 'Book borrowed successfully'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }


    public function show(Borrow $borrow)
    {
        return response()->json([
            'data' => $borrow->load('book')
        ]);
    }

    public function returnBook($id)
    {
        try {
            $borrow = Borrow::findOrFail($id);
            $borrow->update(['returned_at' => now()]);

            return response()->json([
                'data' => $borrow,
                'message' => 'Book returned successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Borrow record not found'
            ], 404);
        }
    }

    public function borrowedBooks()
    {
        $borrows = Borrow::whereNull('returned_at')->get();

        return response()->json([
            'data' => $borrows
        ]);
    }
}
