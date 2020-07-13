@extends('layouts.app')
@section('content')
<div class="w-2/3 bg-gray-400 mx-auto p-6 shadow">
    <form method="post" action="/authors" class="flex flex-col items-center">
        
        @csrf
        <h1>Add New Author</h1>
        <div class="pt-4">
            <input type="text" name="name" placeholder="full name" class="rounded px-2 py-2 w-64">
            @error('name')<p class="text-red-400">{{ $message }}</p> @enderror
        </div>    
        <div class="pt-4">
            <input type="text" name="dob" placeholder="Date of birth" class="rounded px-2 py-2 w-64">
            @error('dob')<p class="text-red-400">{{ $message }}</p> @enderror

        </div>     
        <div class="pt-4">
            <button class="bg-blue-400 text-white rounded py-2 px-2">Add new Author</button>
        </div> 
    </form>    
</div>
@endSection