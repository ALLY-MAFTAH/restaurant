<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

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

        return view('materials', compact('materials'));
    }
    public function postMaterial(Request $request)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'cost' => 'required',
        ]);


        $attributes['status'] = true;
        $material = Material::create($attributes);

        alert()->success('Successfully Added; ' . $material->name);
        return back();

        return view('materials', compact('materials'));
    }
    public function putMaterial(Request $request, Material $material)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'cost' => 'required',
        ]);
        $material->update($attributes);

        alert()->success('Successfully Edited: ' . $material->name);
        return back();
    }
}
