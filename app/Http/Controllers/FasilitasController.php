<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::with('category')->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.fasilitas.create', compact('categories'));
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

    fasilitas::create([
        'name' => $request->name,
        'image' => 'storage/images/' . $imageName,
        'description' => $request->description,
        'price' => $request->price,
        'jumlah' => $request->jumlah,
        'status' => $status,
        'id_category' => $request->id_category
    ]);

    return redirect()->route('admin.fasilitas.index')->with('success', 'Kamar created successfully');
}

    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $categories = Category::all();
        return view('admin.fasilitas.edit', compact('fasilitas', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|string|max:50',
            'id_category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            if ($fasilitas->image && Storage::disk('public')->exists(str_replace('storage/', '', $fasilitas->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $fasilitas->image));
            }
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = 'storage/images/' . basename($path);
        }

        $fasilitas->update($data);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas updated successfully');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        if ($fasilitas->image && Storage::disk('public')->exists(str_replace('storage/', '', $fasilitas->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $fasilitas->image));
        }

        $fasilitas->delete();
        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas deleted successfully');
    }

    // ================= USER / API =================
    // Untuk menampilkan fasilitas di landing page user atau API
    public function apiIndex()
    {
        $fasilitas = Fasilitas::all();
        return response()->json([
            'success' => true,
            'data' => $fasilitas
        ]);
    }

    public function fasilitas()
{
    $fasilitas = fasilitas::with('category')->get();
    return view('landing', compact('fasilitas')); // Variabel $fasilitas dilewatkan ke view 'landing'
}


    public function apiShow($id)
    {
        $fasilitas = Fasilitas::find($id);
        if (!$fasilitas) {
            return response()->json(['success' => false, 'message' => 'Fasilitas not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $fasilitas]);
    }

    public function apiSearch($name)
    {
        $fasilitas = Fasilitas::where('name', 'like', "%$name%")->get();
        if ($fasilitas->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Fasilitas not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $fasilitas]);
    }
}
