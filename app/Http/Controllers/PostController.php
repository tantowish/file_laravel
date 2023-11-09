<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(){
        return view("post.index", [
            'posts'=>Post::paginate(10),
        ]);
    }

    public function create(){
        return view("post.create");
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            "title"=> "required",
            "body"=> "required",
            "image" => "image|nullable|max:2048",
        ]);
    
        // dd($request);
        if ($request->file('image')) {
            $originalImage = $request->file('image');
            $imageName = pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME);
        
            // Save the original image
            $imagePath = 'img/original/' . $imageName . '.' . $originalImage->getClientOriginalExtension();
            Storage::disk('public')->put($imagePath, (string) $originalImage->get());
        
            // Resize the image to 250x250 for square
            $squareImage = Image::make($originalImage)->fit(250, 250);
            $squarePath = 'img/square/' . $imageName . '.' . $originalImage->getClientOriginalExtension();
            Storage::disk('public')->put($squarePath, (string) $squareImage->encode($originalImage->getClientOriginalExtension()));
        
            // Resize the image to 160x90 for thumbnail
            $thumbnailImage = Image::make($originalImage)->fit(160, 90);
            $thumbnailPath = 'img/thumbnail/' . $imageName . '.' . $originalImage->getClientOriginalExtension();
            Storage::disk('public')->put($thumbnailPath, (string) $thumbnailImage->encode($originalImage->getClientOriginalExtension()));
        
            $validatedData['photo'] = $imageName.'.' . $originalImage->getClientOriginalExtension();;
        }

    
        Post::create($validatedData);
        return redirect('/')->with('success', 'New post has been added!'); // Change 'succes' to 'success'
    }


    public function edit($id){
        $post = Post::find($id);
        return view('post.edit', [
            'post'=> $post
        ]);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            "title"=> "required",
            "body"=>"required",
            "image"=>"image|nullable|max:2048",
        ]);
        if($request->file('image')){
            if($request->oldImage){
                Storage::delete("img/original/".$request->oldImage);
                Storage::delete("img/square/".$request->oldImage);
                Storage::delete("img/thumbnail/".$request->oldImage);
            }
            // dd($request->file('image'));
            $originalImage = $request->file('image');
            $imageName = pathinfo($originalImage->getClientOriginalName(), PATHINFO_FILENAME);
        
            // Save the original image
            $imagePath = 'img/original/' . $imageName . '.' . $originalImage->getClientOriginalExtension();
            Storage::disk('public')->put($imagePath, (string) $originalImage->get());
        
            // Resize the image to 250x250 for square
            $squareImage = Image::make($originalImage)->fit(250, 250);
            $squarePath = 'img/square/' . $imageName . '.' . $originalImage->getClientOriginalExtension();
            Storage::disk('public')->put($squarePath, (string) $squareImage->encode($originalImage->getClientOriginalExtension()));
        
            // Resize the image to 160x90 for thumbnail
            $thumbnailImage = Image::make($originalImage)->fit(160, 90);
            $thumbnailPath = 'img/thumbnail/' . $imageName . '.' . $originalImage->getClientOriginalExtension();
            Storage::disk('public')->put($thumbnailPath, (string) $thumbnailImage->encode($originalImage->getClientOriginalExtension()));
        
            $validatedData['photo'] = $imageName.'.' . $originalImage->getClientOriginalExtension();;
        }
        elseif($request->oldImage){
            $validatedData['photo'] = $request->oldImage;
        }

        $store = [
            'title'=>$validatedData['title'],
            'body'=>$validatedData['body'],
            'photo'=> $validatedData['photo'],

        ];
        Post::where('id', $id)
        ->update($store);

        return redirect('/')->with('success', 'Post has been updated!');
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        if($post->photo){
            Storage::delete("img/original/".$post->photo);
            Storage::delete("img/square/".$post->photo);
            Storage::delete("img/thumbnail/".$post->photo);
        }
        $post->delete();
        return redirect("/")->with("deleted","Post has been deleted");
    }
}
