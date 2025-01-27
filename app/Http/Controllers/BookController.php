<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Book::with('category')->get()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id'
            ]);

            $book = Book::create($request->all());

            return response()->json([
                'data' => $book,
                'message' => 'Book created successfully'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show(Book $book)
    {
        return response()->json([
            'data' => $book->load('category')
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id'
            ]);

            $book->update($request->all());

            return response()->json([
                'data' => $book,
                'message' => 'Book updated successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();

            return response()->json([
                'message' => 'Book deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }
    }
}
