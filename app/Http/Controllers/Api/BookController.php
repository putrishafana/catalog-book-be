<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Traits\Response;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    use Response;
    
    /**
     * @OA\Get(
     *     path="/api/book",
     *     summary="Get list of book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for book name",
     *         required=false,
     *         @OA\Schema(type="string", example="John")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of book retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="List book successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="John Doe"),
     *                     @OA\Property(property="desc", type="string", example="Lorem ipsum dolor sit amet"),
     *                     @OA\Property(property="year_publish", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                     @OA\Property(property="author_id", type="integer", example=1),
     *                     @OA\Property(property="publisher_id", type="integer", example=1),
     *                     @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $books = Book::select('id', 'title', 'desc', 'year_publish', 'author_id', 'publisher_id', 'created_at', 'updated_at')
            ->with('authors', 'publishers')
            ->orderBy('created_at', 'asc');

        if ($request->search) {
            $search = $request->search;
            $books->where('title', 'like', "%$search%");
        }

        $perPage = min($request->get('per_page', 10), 100);

        $book = $books->paginate($perPage);

        $author = Author::select('id', 'name')->get();
        $publisher = Publisher::select('id', 'name')->get();
        $data['book'] = $book;
        $data['author'] = $author;
        $data['publisher'] = $publisher;

        return $this->success($data, 'Books retrieved successfully');
    }


    /**
     * @OA\Post(
     *     path="/api/book",
     *     summary="Create a new book",
     *     tags={"Books"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","desc","year_publish","author_id","publisher_id"},
     *             @OA\Property(property="title", type="string", example="John Doe"),
     *             @OA\Property(property="desc", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="year_publish", type="string", example="2023"),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="publisher_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'year_publish' => 'required',
            'author_id' => 'required',
            'publisher_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                $validator->errors(),
                422
            );
        }

        $data = $validator->validated();
        $book = new Book();
        $book->title = $data['title'];
        $book->desc = $data['desc'];
        $book->year_publish = $data['year_publish'];
        $book->author_id = $data['author_id'];
        $book->publisher_id = $data['publisher_id'];
        $book->created_at = now();
        $book->updated_at = now();
        $book->save();

        return $this->success($book, 'Create book successfully', 201);
    }

     /**
     * @OA\Get(
     *     path="/api/book/{id}",
     *     summary="Get detail of a book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="John Doe"),
     *             @OA\Property(property="desc", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="year_publish", type="string", example="2023"),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="publisher_id", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="book not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $book = Book::select('id', 'title', 'desc', 'year_publish', 'author_id', 'publisher_id')
            ->where('id', $id)
            ->with('authors', 'publishers')
            ->first();

        if (!$book) {
            return $this->error('Book not found', 404);
        }

        return $this->success($book, 'Book details retrieved successfully');
    }

    /**
     * @OA\Put(
     *     path="/api/book/{id}",
     *     summary="Update book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","desc","year_publish","author_id","publisher_id"},
     *             @OA\Property(property="title", type="string", example="John Doe"),
     *             @OA\Property(property="desc", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="year_publish", type="string", example="2023"),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="publisher_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="book updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="book not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed"
     *     )
     * )
     */

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'year_publish' => 'required',
            'author_id' => 'required',
            'publisher_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                $validator->errors(),
                422
            );
        }

        $book = Book::find($id);
        if (!$book) {
            return $this->error('Book not found', null, 404);
        }

        $data = $validator->validated();

        $book->title = $data['title'];
        $book->desc = $data['desc'];
        $book->year_publish = $data['year_publish'];
        $book->author_id = $data['author_id'];
        $book->publisher_id = $data['publisher_id'];
        $book->updated_at = now();
        $book->save();

        return $this->success($book, 'Update book successfully', 200);
    }

   /**
     * @OA\Delete(
     *     path="/api/book/{id}",
     *     summary="Delete a book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="book ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="book deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="book not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if ($book) {
            $book->delete();
        }

        return $this->success($book, 'Delete book successfully');
    }
}