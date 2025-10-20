<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::with('cities')->get();
        return response()->json($provinces);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // For web routes
        return view('admin.province.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:province,name',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $province = Province::create($request->only(['name']));

        if ($request->expectsJson()) {
            return response()->json($province, 201);
        }

        return redirect()->route('admin.province.index')->with('success', 'Province created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province)
    {
        $province->load('cities');
        return response()->json($province);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        // For web routes
        return view('admin.province.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:province,name,' . $province->id,
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $province->update($request->only(['name']));

        if ($request->expectsJson()) {
            return response()->json($province);
        }

        return redirect()->route('admin.province.index')->with('success', 'Province updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        $province->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Province deleted successfully']);
        }

        return redirect()->route('admin.province.index')->with('success', 'Province deleted successfully');
    }
}
