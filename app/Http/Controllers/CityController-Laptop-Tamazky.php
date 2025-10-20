<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('province')->get();
        return response()->json($cities);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::all();
        return view('admin.city.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_province' => 'required|exists:province,id',
            'name' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $city = City::create($request->only(['id_province', 'name']));

        if ($request->expectsJson()) {
            return response()->json($city->load('province'), 201);
        }

        return redirect()->route('admin.city.index')->with('success', 'City created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        $city->load('province');
        return response()->json($city);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $provinces = Province::all();
        return view('admin.city.edit', compact('city', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'id_province' => 'required|exists:province,id',
            'name' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $city->update($request->only(['id_province', 'name']));

        if ($request->expectsJson()) {
            return response()->json($city->load('province'));
        }

        return redirect()->route('admin.city.index')->with('success', 'City updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'City deleted successfully']);
        }

        return redirect()->route('admin.city.index')->with('success', 'City deleted successfully');
    }
}
