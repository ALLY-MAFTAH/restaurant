<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
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
        $products = Product::all();
        $items = Item::where('status', 1)->get();

        return view('products.index', compact('products', 'items'));
    }

    // SHOW PRODUCT
    public function showProduct(Request $request, Product $product)
    {
        $products = Product::all();
        $items = Item::where('status', 1)->get();
        $ingredients = $product->ingredients;
        // dd($ingredients);

        return view('products.show', compact('products', 'product', 'ingredients', 'items'));
    }

    // POST PRODUCT
    public function postProduct(Request $request)
    {

        $item = Item::findOrFail($request->input('item_id'));
        try {
            $attributes = $this->validate($request, [
                'container' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'price' => 'required',
                'item_id' => 'required',
            ]);

            $attributes['status'] = true;

            $product = Product::create($attributes);

            $item->products()->save($product);
            $newQuantity = $item->quantity - $product->quantity;

            $item->update([
                'quantity' => $newQuantity,
            ]);
            $item->save();
        } catch (QueryException $th) {
            notify()->error('Product "' . $request->name . '" with quantity of "' . $request->quantity . '" already exists.');
            return back();
        }
        notify()->success('You have successful added a product');

        return Redirect::back();
    }

    // EDIT PRODUCT
    public function putProduct(Request $request, Product $product)
    {
        $item = Item::findOrFail($request->item_id);

        try {
            $attributes = $this->validate($request, [
                'container' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'price' => 'required',
            ]);

            $attributes['item_id'] = $item->id;

            $product->update($attributes);

            $newQuantity = $item->quantity - $product->quantity;

            $item->update([
                'quantity' => $newQuantity,
            ]);
            $item->save();
        } catch (QueryException $th) {
            notify()->error('Product "' . $request->name . '" with quantity of "' . $request->quantity . '" already exists.');
            return back();
        }
        notify()->success('You have successful edited an product');
        return redirect()->back();
    }


    // TOGGLE PRODUCT STATUS
    public function toggleStatus(Request $request, Product $product)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $product->update($attributes);

        notify()->success('You have successfully updated product status');
        return back();
    }

    // DELETE PRODUCT
    public function deleteProduct(Request $request, Product $product)
    {

        $itsName = $product->name;
        $product->delete();

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
