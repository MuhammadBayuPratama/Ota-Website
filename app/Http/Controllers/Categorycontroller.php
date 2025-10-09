<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // ===================== API JSON =====================
    public function indexApi()
    {
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function showApi($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function searchApi(Request $request)
{
    $name = $request->query('q');
    $categories = Category::where('category', 'like', "%{$name}%")->get();
    return $categories->isEmpty()
        ? response()->json(['success' => false, 'message' => 'Category not found'], 404)
        : response()->json(['success' => true, 'data' => $categories]);
}

    public function storeApi(Request $request)
    {
        $validator = Validator::make($request->only('category'), [
            'category' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $category = Category::create(['category' => $request->category]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    public function updateApi(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $validator = Validator::make($request->only('category'), [
            'category' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $category->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    public function destroyApi($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted successfully'], 200);
    }

    // ===================== WEB BLADE =====================
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:50',
        ]);

        Category::create(['category' => $request->category]);
        return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category.index')->with('error', 'Category not found');
        }
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category.index')->with('error', 'Category not found');
        }

        $request->validate([
            'category' => 'required|string|max:50',
        ]);

        $category->update(['category' => $request->category]);
        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category.index')->with('error', 'Category not found');
        }

        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }
}
