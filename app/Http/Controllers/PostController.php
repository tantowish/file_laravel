<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(){
        return view("post.index", [
            'posts'=>Post::all(),
        ]);
    }

    public function create(){
        return view("post.create");
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            "title"=> "required",
            "body"=>"required",
            "photo"=>"image|nullable|max:2048",
        ]);

        if($request->file('image')){
            $validatedData['photo'] = $request->file('image')->store('img/post-images');
        }
        Post::create($validatedData);
        return redirect('/')->with('succes', 'New post has been added!');
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
            "photo"=>"image|nullable|max:2048",
        ]);
        if($request->file('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            // dd($request->file('image'));
            $validatedData['photo'] = $request->file('image')->store('img/post-images');
        }
        Post::where('id', $id)
        ->update($validatedData);

        return redirect('/')->with('succes', 'Post has been updated!');
    }
}
