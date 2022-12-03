<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MaterialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $materials = Material::all();

        return view('materials.index', compact('materials'));
    }
    public function showMaterial(Request $request, Material $material)
    {
        $materials = Material::where('status', 1)->get();

        return view('materials.show', compact('material', 'materials'));
    }
    public function postMaterial(Request $request)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'cost' => 'required',
        ]);

        $attributes['status'] = true;
        $material = Material::create($attributes);

        notify()->success('You have successful added material');

        return Redirect::back();

    }
    public function putMaterial(Request $request, Material $material)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'cost' => 'required',
        ]);

        $material->update($attributes);

        notify()->success('You have successful edited material');
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Material $material)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $material->update($attributes);

        notify()->success('You have successfully updated material status');
        return back();
    }
    public function deleteMaterial(Request $request, Material $material)
    {

        $itsName=$material->name;
        $material->delete();

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}

