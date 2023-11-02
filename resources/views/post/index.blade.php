@extends('layouts.main')

@section('content')
    <div class="p-8 lg:px-32 mx-auto">
        @if (session('success'))
            {{ session('success') }}
        @endif
        <div>
            <a href="{{ route('post.create') }}">
                <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Create Post</button></a>
        </div>
    </div>
    <div class="p-8 lg:px-32 mx-auto flex flex-wrap gap-4">
        @foreach ($posts as $post)
        <a href="{{ route('post.edit', $post->id) }}" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            @if ($post->photo)
            <img class="object-cover w-full rounded-t-lg h-48 md:h-auto md:w-36 md:rounded-none md:rounded-l-lg" src="storage/{{  $post->photo  }}" alt="">
            @else
            <p class="px-8">Tidak ada photo</p>
            @endif
            
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $post->title }}</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $post->body }}</p>
            </div>
        </a>
        @endforeach
    </div>
@endsection