<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use App\Helpers\ApiFormatter;
use Exception;
use Facade\FlareClient\Api;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function borrow(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'user_id' => 'required|exists:users,id'
            ]);
    
            // Check if the loan already exists for the user and book
            $existingLoan = Loan::where('user_id', $request->user_id)
                ->where('book_id', $request->book_id)
                ->whereNull('returned_at') // Ensure the loan is not returned
                ->first();
    
            if ($existingLoan) {
                // If the loan exists, return an error
                return ApiFormatter::createApi(400, 'Book already borrowed');
            }
    
            $book = Book::find($request->book_id);
    
            if (!$book->available) {
                return ApiFormatter::createApi(400, 'Book already borrowed');
            }
    
            $loan = Loan::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'borrowed_at' => now()
            ]);
    
            $book->update(['available' => false]);

            return ApiFormatter::createApi(200, 'Success borrow book', $loan);

        } catch (Exception $e) {
            return ApiFormatter::createApi(400, $e->getMessage());
        }
    }

    public function return(Request $request)
    {
        try {
            $request->validate([
                'book_id' => 'required|exists:books,id',
                'user_id' => 'required|exists:users,id'
            ]);
    
            $loan = Loan::where('user_id', $request->user_id)
                ->where('book_id', $request->book_id)
                ->whereNull('returned_at')
                ->first();
    
            if (!$loan) {
                return ApiFormatter::createApi(400, 'Book not borrowed');
            }
    
            $loan->update(['returned_at' => now()]);
    
            $book = Book::find($request->book_id);
            $book->update(['available' => true]);

            return ApiFormatter::createApi(200, 'Success return book', $loan);

        } catch (Exception $e) {
            return ApiFormatter::createApi(400, $e->getMessage());
        }
    }

    public function userLoans($id)
    {
        $loan = Loan::where('user_id', $id)
            ->whereNull('returned_at') // Ensure the loan has not been returned
            ->with(['book:id,title']) // Specify the fields to retrieve
            ->get();

        if(count($loan) > 0) {
            return ApiFormatter::createApi(200, 'Success', $loan);
        } else {
            return ApiFormatter::createApi(400, 'No loans found');
        }
    }
}