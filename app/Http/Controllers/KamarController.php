<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    // ===================== API JSON =====================
    public function indexApi()
    {
        $kamars = Kamar::all();
        return response()->json([
            'success' => true,
            'data' => $kamars
        ]);
    }

    public function showApi($id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['success' => false, 'message' => 'Kamar not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $kamar]);
    }

    public function searchApi($name)
    {
        $kamars = Kamar::where('name', 'like', "%$name%")->get();
        if ($kamars->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Kamar not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $kamars]);
    }

    public function storeApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string|max:50',
            'id_category' => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $file = $request->file('image');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('images', $imageName, 'public');

        $kamar = Kamar::create([
            'name' => $request->name,
            'image' => 'storage/images/' . $imageName,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status,
            'id_category' => $request->id_category
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kamar created successfully',
            'data' => $kamar
        ], 201);
    }

    public function updateApi(Request $request, $id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['success' => false, 'message' => 'Kamar not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string|max:50',
            'id_category' => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $kamar->update($validator->validated());
        return response()->json(['success' => true, 'message' => 'Kamar updated successfully', 'data' => $kamar]);
    }

    public function destroyApi($id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['success' => false, 'message' => 'Kamar not found'], 404);
        }

        if ($kamar->image && Storage::disk('public')->exists(str_replace('storage/', '', $kamar->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $kamar->image));
        }

        $kamar->delete();
        return response()->json(['success' => true, 'message' => 'Kamar deleted successfully'], 204);
    }

    // ===== WEB BLADE =====
public function index()
{
    $kamars = Kamar::with('category')->get();
    return view('admin.kamar.index', compact('kamars'));
}

public function kamar()
{
    $kamars = Kamar::with('category')->get();
    return view('landing', compact('kamars'));
}

public function create()
{
    $categories = Category::all();
    return view('admin.kamar.create', compact('categories'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:50',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        'description' => 'required|string|max:255',
        'price' => 'required|numeric',
        'id_category' => 'required|exists:categories,id',
        'jumlah' => 'required|integer|min:0',
    ]);

    $file = $request->file('image');
    $imageName = time() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('images', $imageName, 'public');

    $status = $request->jumlah > 0 ? 'Tersedia' : 'Penuh';

    Kamar::create([
        'name' => $request->name,
        'image' => 'storage/images/' . $imageName,
        'description' => $request->description,
        'price' => $request->price,
        'jumlah' => $request->jumlah,
        'status' => $status,
        'id_category' => $request->id_category
    ]);

    return redirect()->route('admin.kamar.index')->with('success', 'Kamar created successfully');
}

public function edit($id)
{
    $kamar = Kamar::findOrFail($id);
    $categories = Category::all();
    return view('admin.kamar.edit', compact('kamar', 'categories'));
}

public function update(Request $request, $id)
{
    $kamar = Kamar::find($id);
    if (!$kamar) {
        return redirect()->route('admin.kamar.index')->with('error', 'Kamar not found');
    }

    $request->validate([
        'name' => 'required|string|max:50',
        'description' => 'required|string|max:255',
        'price' => 'required|numeric',
        'id_category' => 'required|exists:categories,id',
        'jumlah' => 'required|integer|min:0',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        if ($kamar->image && Storage::disk('public')->exists(str_replace('storage/', '', $kamar->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $kamar->image));
        }
        $file = $request->file('image');
        $imageName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('images', $imageName, 'public');
        $data['image'] = 'storage/images/' . $imageName;
    } else {
        unset($data['image']);
    }

    $data['status'] = $request->jumlah > 0 ? 'Tersedia' : 'Penuh';

    $kamar->update($data);

    return redirect()->route('admin.kamar.index')->with('success', 'Kamar updated successfully');
}


    public function destroy($id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return redirect()->route('kamar.index')->with('error', 'Kamar not found');
        }

        if ($kamar->image && Storage::disk('public')->exists(str_replace('storage/', '', $kamar->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $kamar->image));
        }

        $kamar->delete();
        return redirect()->route('admin.kamar.index')->with('success', 'Kamar deleted successfully');
    }
}
