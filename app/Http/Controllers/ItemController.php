<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use App\Models\Ingredient;
use App\Models\Item;
use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
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
        $filteredDate =null;
        $selectedDate = null;
        $filteredSales=[];
        $filteredDate = $request->get('filteredDate', "All Days");

        if ($filteredDate == null) {
            $filteredDate = "All Days";
        }

        if ($filteredDate == "All Days") {
            $filteredSales = $item->sales;
        } else {
            $filteredSales = $item->sales->where('date', $filteredDate);
        }
        $selectedDate = $filteredDate;

        $items = Item::all();
        $materials = Material::where('status', 1)->get();
        $ingredients = $item->ingredients;
        // dd($sales);
        $products = $item->products;

        return view('items.show', compact('items','filteredDate', 'item','products', 'filteredSales', 'ingredients', 'materials'));
    }

    // POST ITEM
    public function postItem(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'cost' => 'required',
            ]);

            $attributes['status'] = true;
            $item = Item::create($attributes);
            ActivityLogHelper::addToLog('Added item '.$item->name);

        } catch (QueryException $th) {
            notify()->error('Failed to add item "' . $request->name . '". It already exists.');
            return back();
        }
        // Add Item Ingredients
        try {

            self::postIngredients($request, $item);
            notify()->success('You have successful added an item');
            return back();
        } catch (QueryException $th) {
            $failedId = $th->getBindings()[3];

            $material = Material::findOrFail($failedId);
            notify()->error($material->name . ' already exist in ' . $item->name);
            return back()->with('error', 'Failed to add ingredient "' . $material->name . '". It already exists in ' . $item->name);
        }
    }

    // EDIT ITEM
    public function putItem(Request $request, Item $item)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'cost' => 'required',
            ]);

            $item->update($attributes);
            ActivityLogHelper::addToLog('Updated item '.$item->name);
        } catch (QueryException $th) {
            notify()->error('Failed to edit item. "' . $request->name . '" already exists.');
            return back();
        }
        notify()->success('You have successful edited an item');
        return redirect()->back();
    }

    // POST INGREDIENTS
    public function postIngredients(Request $request, Item $item)
    {
        // Add Item Ingredients
        $ingredientsIds = $request->input('ids');
        $ingredientsQuantities = $request->input('quantities');
        $ingredientsUnits = $request->input('units');

        try {

            for ($i = 0; $i < count($ingredientsIds); $i++) {

                $ingredient = new Ingredient();
                $ingredient->quantity = $ingredientsQuantities[$i];
                $ingredient->unit = $ingredientsUnits[$i];
                $ingredient->item_id = $item->id;
                $ingredient->material_id = $ingredientsIds[$i];
                $ingredient->status = true;

                $item->ingredients()->save($ingredient);
                $material = Material::findOrFail($ingredientsIds[$i]);
                $newQuantity = $material->quantity - $ingredient->quantity;

                $material->update([
                    'quantity' => $newQuantity,
                ]);
                $material->save();
            }
            ActivityLogHelper::addToLog('Added ingredient to item '.$item->name);

            notify()->success('You have successful added ingredients in ' . $item->name);
            return redirect()->back();
        } catch (QueryException $th) {
            // dd($th->getBindings());
            $failedId = $th->getBindings()[3];

            $material = Material::findOrFail($failedId);
            notify()->error($material->name . ' already exist in ' . $item->name);
            return back()->with('error', 'Failed to add ingredient "' . $material->name . '". It already exists in ' . $item->name);
        }
    }
    // EDIT INGREDIENTS
    public function putIngredients(Request $request, Item $item)
    {
        // Add Item Ingredients
        $ingredientIds = $request->input('ingredient_id');
        $ingredientsQuantities = $request->input('quantities');
        $ingredientsUnits = $request->input('units');

        for ($i = 0; $i < count($ingredientIds); $i++) {
            $ingredient = Ingredient::findOrFail($ingredientIds[$i]);
            $ingredient->update([
                'quantity' => $ingredientsQuantities[$i],
                'unit' => $ingredientsUnits[$i],
            ]);
            $ingredient->save();
            ActivityLogHelper::addToLog('Updated ingredient '.$ingredient->name);

            $material = Material::findOrFail($ingredient->material_id);

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
        ActivityLogHelper::addToLog('Switched item '.$item->name.' status ');

        notify()->success('You have successfully updated item status');
        return back();
    }

    // DELETE ITEM
    public function deleteItem( Item $item)
    {

        $itsName = $item->name;
        $item->delete();
        ActivityLogHelper::addToLog('Deleted item '.$item->name);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
    // DELETE INGREDIENT
    public function deleteIngredient( Ingredient $ingredient)
    {

        $itsName = $ingredient->name;
        $ingredient->delete();
        ActivityLogHelper::addToLog('Deleted ingredient '.$ingredient->name);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
