<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;
use App\Traits\Response;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{
    use Response;

    /**
     * @OA\Get(
     *     path="/api/publisher",
     *     summary="Get list of publisher",
     *     tags={"Publishers"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword for publisher name or bio",
     *         required=false,
     *         @OA\Schema(type="string", example="John")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of publishers retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="List publishers successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="address", type="string", example="Lorem ipsum dolor sit amet"),
     *                     @OA\Property(property="email", type="string", example="Lorem ipsum dolor sit amet"),     
     *                     @OA\Property(property="phone", type="string", example="Lorem ipsum dolor sit amet"),
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
        $query = Publisher::select('id', 'name', 'address', 'email', 'phone', 'created_at', 'updated_at')
            ->orderBy('created_at', 'asc');

        if ($request->search) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%");
        }

        $perPage = min($request->get('per_page', 10), 100);

        $data = $query->paginate($perPage);

        return $this->success(collect($data), 'Publishers retrieved successfully');
    }


    /**
     * @OA\Post(
     *     path="/api/publisher",
     *     summary="Create a new publisher",
     *     tags={"Publishers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","address","email","phone"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="address", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="email", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="phone", type="string", example="Lorem ipsum dolor sit amet")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Publisher created successfully"
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
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                $validator->errors(),
                422
            );
        }

        $data = $validator->validated();
        $publisher = new Publisher();
        $publisher->name = $data['name'];
        $publisher->address = $data['address'];
        $publisher->email = $data['email'];
        $publisher->phone = $data['phone'];
        $publisher->created_at = now();
        $publisher->updated_at = now();
        $publisher->save();

        return $this->success($publisher, 'Create publisher successfully', 201);
    }

    /**
     * @OA\Get(
     *     path="/api/publisher/{id}",
     *     summary="Get detail of a publisher by ID",
     *     tags={"Publishers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Publisher ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publisher retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="address", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="email", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="phone", type="string", example="Lorem ipsum dolor sit amet"),
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
        $publisher = Publisher::select('id', 'name', 'address', 'email', 'phone', 'created_at', 'updated_at')->where('id', $id)->first();

        if (!$publisher) {
            return $this->error('Publisher not found', 404);
        }
        return $this->success($publisher, 'Publisher details retrieved');
    }


    /**
     * @OA\Put(
     *     path="/api/publisher/{id}",
     *     summary="Update publisher",
     *     tags={"Publishers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Publisher ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "address", "email", "phone"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="address", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="email", type="string", example="Lorem ipsum dolor sit amet"),
     *             @OA\Property(property="phone", type="string", example="Lorem ipsum dolor sit amet")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="publisher updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="publisher not found"
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
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->error(
                'Validation failed',
                $validator->errors(),
                422
            );
        }

        $data = $validator->validated();

        $publisher = Publisher::find($id);
        $publisher->name = $data['name'];
        $publisher->address = $data['address'];
        $publisher->email = $data['email'];
        $publisher->phone = $data['phone'];
        $publisher->updated_at = now();
        $publisher->save();

        return $this->success($publisher, 'Update publisher successfully', 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/publisher/{id}",
     *     summary="Delete a publisher by ID",
     *     tags={"Publishers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="publisher ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="publisher deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="publisher not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $publisher = Publisher::find($id);

        if ($publisher) {
            $publisher->delete();
        }

        return $this->success($publisher, 'Delete publisher successfully');
    }
}