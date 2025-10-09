@extends('layouts.app_admin')

@section('title', 'Edit Category')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Category</h2>
<form action="{{ route('admin.category.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label>Nama Category</label>
        <input type="text" name="category" class="w-full border p-2 rounded" 
               value="{{ $category->category }}" required>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
