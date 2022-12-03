<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Item;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ItemController extends Controller
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
        $items = Item::all();
        $materials = Material::where('status', 1)->get();

        return view('items.index', compact('items', 'materials'));
    }

    // SHOW ITEM
    public function showItem(Request $request, Item $item)
    {
        $items = Item::all();
        $materials = Material::where('status', 1)->get();
        $ingredients = $item->ingredients;
        // dd($ingredients);

        return view('items.show', compact('items', 'item', 'ingredients', 'materials'));
    }

    // POST ITEM
    public function postItem(Request $request)
    {

        $attributes = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'cost' => 'required',
        ]);

        $attributes['status'] = true;
        $item = Item::create($attributes);

        // Add Item Ingredients
        $ingredientsIds = $request->input('ingredient_name');
        $ingredientsQuantities = $request->input('ingredient_quantity');
        $ingredientsUnits = $request->input('ingredient_unit');


        for ($i = 0; $i < count($ingredientsIds); $i++) {
            // dd($i);
            $material = Material::findOrFail($ingredientsIds[$i]);
            $ingredient = new Ingredient();
            $ingredient->name = $material->name;
            $ingredient->quantity = $ingredientsQuantities[$i];
            $ingredient->unit = $ingredientsUnits[$i];
            $ingredient->item_id = $item->id;
            $ingredient->material_id = $ingredientsIds[$i];
            $ingredient->status = true;

            $item->ingredients()->save($ingredient);
            $newQuantity = $material->quantity - $ingredient->quantity;

            $material->update([
                'quantity' => $newQuantity,
            ]);
            $material->save();
        }

        notify()->success('You have successful added an item');

        return Redirect::back();
    }

    // EDIT ITEM
    public function putItem(Request $request, Item $item)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'cost' => 'required',
        ]);

        $item->update($attributes);

        notify()->success('You have successful edited an item');
        return redirect()->back();
    }

    // POST INGREDIENTS
    public function postIngredients(Request $request, Item $item)
    {
        // dd('d');

        // Add Item Ingredients
        $ingredientsIds = $request->input('ingredient_name');
        $ingredientsQuantities = $request->input('ingredient_quantity');
        $ingredientsUnits = $request->input('ingredient_unit');

        for ($i = 0; $i < count($ingredientsIds); $i++) {
            // dd($i);
            $material = Material::findOrFail($ingredientsIds[$i]);
            $ingredient = new Ingredient();
            $ingredient->name = $material->name;
            $ingredient->quantity = $ingredientsQuantities[$i];
            $ingredient->unit = $ingredientsUnits[$i];
            $ingredient->item_id = $item->id;
            $ingredient->material_id = $ingredientsIds[$i];
            $ingredient->status = true;

            $item->ingredients()->save($ingredient);
            $newQuantity = $material->quantity - $ingredient->quantity;

            $material->update([
                'quantity' => $newQuantity,
            ]);
            $material->save();
        }
        notify()->success('You have successful updated ' . $item->name . ' ingredients');
        return redirect()->back();
    }
    // EDIT INGREDIENTS
    public function putIngredients(Request $request, Item $item)
    {
        // dd($item->name);

        // Add Item Ingredients
        $ingredientsIds = $request->input('ingredient_id');
        $ingredientsNames = $request->input('ingredient_name');
        $ingredientsQuantities = $request->input('ingredient_quantity');
        $ingredientsUnits = $request->input('ingredient_unit');

        for ($i = 0; $i < count($ingredientsIds); $i++) {
            $ingredient = Ingredient::findOrFail($ingredientsIds[$i]);
            $ingredient->update([
                'name' => $ingredientsNames[$i],
                'quantity' => $ingredientsQuantities[$i],
                'unit' => $ingredientsUnits[$i],
            ]);
            $ingredient->save();
            
            $material = Material::where('name', $ingredientsNames[$i])->first();

            $newQuantity = $material->quantity - $ingredient->quantity;

            $material->update([
                'quantity' => $newQuantity,
            ]);
            $material->save();
        }

        notify()->success('You have successful updated ' . $item->name . ' ingredients');
        return redirect()->back();
    }

    // TOGGLE ITEM STATUS
    public function toggleStatus(Request $request, Item $item)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $item->update($attributes);

        notify()->success('You have successfully updated item status');
        return back();
    }

    // DELETE ITEM
    public function deleteItem(Request $request, Item $item)
    {

        $itsName = $item->name;
        $item->delete();

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
    // DELETE INGREDIENT
    public function deleteIngredient(Request $request, Ingredient $ingredient)
    {

        $itsName = $ingredient->name;
        $ingredient->delete();

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
