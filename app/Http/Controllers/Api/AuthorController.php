<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Traits\Response;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    use Response;
   
    /**
     * @OA\Get(
     *     path="/api/author",
     *     summary="Get list of authors",
     *     tags={"Authors"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for author name or bio",
     *         required=false,
     *         @OA\Schema(type="string", example="John")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of authors retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="List authors successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="bio", type="string", example="Lorem ipsum dolor sit amet"),
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
        $author = Author::select('id', 'name', 'bio', 'created_at', 'updated_at')
            ->orderBy('created_at', 'asc');

        if($request->search){
            $search = $request->search;
            $author->where('name', 'like', "%$search%");
        }
        
        $perPage = min($request->get('per_page', 10), 100);
        $data = $author->paginate($perPage);

        return $this->success($data, 'Authors retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/author",
     *     summary="Create a new author",
     *     tags={"Authors"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","bio"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="bio", type="string", example="Lorem ipsum dolor sit amet"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created successfully"
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
            'name' => 'required',
            'bio' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                $validator->errors(),
                422
            );
        }
        $data = $validator->validated();
        
        $author = new Author();
        $author->name = $data['name'];
        $author->bio = $data['bio'];
        $author->created_at = now();
        $author->updated_at = now();
        $author->save();

        return $this->success($author, 'Create author successfully', 201);
    }

    /**
     * @OA\Get(
     *     path="/api/author/{id}",
     *     summary="Get detail of a author by ID",
     *     tags={"Authors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Author ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="bio", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="created_at", type="string", example="2023-01-01T00:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2023-01-01T00:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="author not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $author = Author::select('id', 'name', 'bio', 'created_at', 'updated_at')->where('id', $id)->first();

        if(!$author){
            return $this->error('Author not found', 404);
        }
        return $this->success($author, 'Author details retrieved');
    }

    /**
     * @OA\Put(
     *     path="/api/author/{id}",
     *     summary="Update author",
     *     tags={"Authors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Author ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","bio"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="bio", type="string", example="Lorem ipsum dolor sit amet"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="author updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="author not found"
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
            'name' => 'required',
            'bio' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                $validator->errors(),
                422
            );
        }
        $data = $validator->validated();

        $author = Author::find($id);
        $author->name = $data['name'];
        $author->bio = $data['bio'];
        $author->updated_at = now();
        $author->save();

        return $this->success($author, 'Update author successfully', 201);
    }

    /**
     * @OA\Delete(
     *     path="/api/author/{id}",
     *     summary="Delete a author by ID",
     *     tags={"Authors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="author ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="author deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="author not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $author = Author::find($id);

        if($author){
            $author->delete();
        }

        return $this->success($author, 'Delete author successfully');
    }
}