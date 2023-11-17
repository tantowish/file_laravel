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

    public function store(Request $request){
        $validatedData = $request->validate([
            "title"=> "required",
            "body"=> "required",
            "image" => "required",
        ]);
    
        Post::create($validatedData);
        return new GalleryResource($validatedData);
    }
}
