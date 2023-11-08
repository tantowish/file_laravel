@extends('layouts.main')

@section('content')
<div class="p-8 lg:px-32 mx-auto">
    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" id="title" name="title" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="Post title" required  value='{{ old('title', $post->title) }}'>
            @error('title')
            <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body</label>
            <textarea id="message" name="body" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Body of content">{{ old('body', $post->body) }}</textarea>
            @error('body')
            <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-6">
            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Image</label>
            <input type="hidden" name="oldImage" value="{{ $post->photo }}">
            @if ($post->photo)
            <img src="{{ asset('storage/img/original/'.$post->photo) }}" class="img-preview max-h-[300px] mb-5">
            @else
            <img class="img-preview max-h-[300px] mb-5">
            @endif
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="image" name="image" type="file" onchange="previewImage()">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
            @error('image')
                <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create Post</button>
    </form>
</div>

<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug')

    title.addEventListener('change', function(){
        const inputValue = title.value.trim(); // Trim any leading or trailing spaces

    if (inputValue === "") {
        // If the title is blank, you may choose to handle this differently, e.g., set a default value for the slug.
        // For now, let's assume you want to set the slug to an empty string when title is blank.
        slug.value = "";
        } 
        else {
            // If title is not blank, make the fetch request and update the slug based on the response.
            fetch('/dashboard/posts/checkSlug?title=' + inputValue)
                .then(response => response.json())
                .then(data => slug.value = data.slug);
        }
    })

    document.addEventListener('trix-file-accept', function(e){
        e.preventDefault();
    })

    function previewImage(){
        const image = document.querySelector('#image')
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block'

        const oFReader = new FileReader()
        oFReader.readAsDataURL(image.files[0]);
        
        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result
        };
    }
</script>
@endsection