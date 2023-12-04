<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\GalleryResource;

class GalleryController extends Controller
   /**
    * @OA\Get(
    * path="/api/gallery",
    * tags={"gallery"},
    * summary="Returns a list of gallery items",
    * description="Get a list of all gallery items",
    * operationId="gallery",
    * @OA\Response(
    *       response="default",
    *       description="successful operation"
    *       )
    *       )
    */
    

{
    public function index(){
        $posts = Post::all();
        return GalleryResource::collection($posts);
    }

    /**
 * @OA\Post(
 *     path="/api/gallery",
 *     tags={"gallery"},
 *     summary="Create a new gallery item",
 *     description="Create a new gallery item with title, body, and image",
 *     operationId="createGalleryItem",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Gallery item details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     type="string",
 *                     description="Title of the gallery item"
 *                 ),
 *                 @OA\Property(
 *                     property="body",
 *                     type="string",
 *                     description="Body/content of the gallery item"
 *                 ),
 *                 @OA\Property(
 *                     property="image",
 *                     type="string",
 *                     format="url",
 *                     description="URL of the image for the gallery item"
 *                 ),
 *                 example={"title": "Sample Title", "body": "Sample Body", "image": "https://example.com/sample-image.jpg"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Gallery item created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Gallery item created successfully"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/GalleryItem"  // Reference to a schema for the gallery item (you can define this separately)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Error occurred"
 *     )
 * )
 */
    

    public function store(Request $request){
        $validatedData = $request->validate([
            "title"=> "required",
            "body"=> "required",
            "photo" => "required",
        ]);
    
        Post::create($validatedData);
        return new GalleryResource($validatedData);
    }
}
