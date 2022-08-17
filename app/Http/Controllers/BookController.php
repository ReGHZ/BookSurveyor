<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        return view('admin.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser(Request $request)
    {
        $user = Auth::user();
        $books = $user->books;

        if ($request->ajax()) {
            if ($request->ajax()) {
                return Datatables::of($books)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {

                        $btn = '<a data-id="' . $row->id . '" class="edit btn btn-primary me-2">Edit</a>';
                        $btn = $btn . '<a data-id="' . $row->id . '" class="btndelete btn btn-danger btn-sm">Delete</a>';

                        return $btn;

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }
        return view('user.dashboard', compact('books'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBookUser()
    {
        $user = Auth::user();
        $books = $user->books;

        return response()->json([
            'books' => $books
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'code' => 'required|unique:books',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'errors' => $validator->messages()
                ]
            );
        } else {

            Book::create($request->only([
                'user_id',
                'title',
                'code',
                'author',
                'description'
            ]));

            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Book is successfully added'
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editBookUser($id)
    {
        $book = Book::find($id);
        if ($book) {
            return response()->json([
                'status' => 200,
                'book' => $book
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Book not found'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBookUser(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'errors' => $validator->messages()
                ]
            );
        } else {

            Book::find($id)->update($request->only([
                'user_id',
                'title',
                'code',
                'author',
                'description'
            ]));

            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Book is successfully updated'
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteBookUser($id)
    {
        $book = Book::find($id);
        if ($book) {
            $book->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Book is successfully deleted'
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Book not found'
            ]);
        }
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
}
