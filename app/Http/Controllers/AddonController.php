<?php
namespace App\Http\Controllers;

use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    /**
     * Menampilkan daftar semua Addon (menggunakan Blade View).
     */
    public function index()
    {
        $addons = Addon::all();
        // PERUBAHAN UTAMA: Menggunakan 'admin.addons.index'
        return view('admin.addons.index', compact('addons'));
    }

    /**
     * Menampilkan form untuk membuat Addon baru (View).
     */
    public function create()
    {
        // PERUBAHAN UTAMA: Menggunakan 'admin.addons.create'
        return view('admin.addons.create');
    }

    /**
     * Menyimpan Addon baru ke database (Action POST).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500', 
        ]);

        $addon = Addon::create($validated);
        
        return redirect()->route('addons.index')
                         ->with('success', "Add-on '{$addon->name}' berhasil ditambahkan!");
    }

    /**
     * Menampilkan Addon tertentu (View).
     */
    public function show(Addon $addon)
    {
        // PERUBAHAN UTAMA: Menggunakan 'admin.addons.show' (Jika Anda membuatnya)
        return view('admin.addons.show', compact('addon'));
    }

    /**
     * Menampilkan form untuk mengedit Addon yang ada (View).
     */
    public function edit(Addon $addon)
    {
        // PERUBAHAN UTAMA: Menggunakan 'admin.addons.edit'
        return view('admin.addons.edit', compact('addon'));
    }

    /**
     * Memperbarui Addon yang ada di database (Action PUT/PATCH).
     */
    public function update(Request $request, Addon $addon)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'price'       => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string|max:500', 
        ]);

        $addon->update($validated);
        
        return redirect()->route('addons.index')
                         ->with('success', "Add-on '{$addon->name}' berhasil diperbarui!");
    }

    /**
     * Menghapus Addon dari database.
     */
    public function destroy(Addon $addon)
    {
        $addon->delete();
        
        return redirect()->route('addons.index')
                         ->with('success', 'Add-on berhasil dihapus!');
    }
}