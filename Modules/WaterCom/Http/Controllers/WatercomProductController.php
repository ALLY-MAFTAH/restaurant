<?php

namespace Modules\Watercom\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Modules\Watercom\Entities\WatercomProduct;
use Modules\Watercom\Entities\WatercomStock;

class WatercomProductController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = WatercomProduct::latest()->get();
        $stocks = WatercomStock::latest()->get();

        return view('watercom::products.index', compact('products', 'stocks'));
    }

    // SHOW PRODUCT
    public function showWatercomProduct(Request $request, WatercomProduct $product)
    {

        $stocks = WatercomStock::where(['status' => 1])->get();
        $ingredients = $product->ingredients;

        return view('watercom::products.show', compact('product', 'ingredients', 'stocks'));
    }

    // POST PRODUCT
    public function postWatercomProduct(Request $request)
    {
        $stock = WatercomStock::findOrFail($request->watercom_stock_id);

        try {
            $attributes = $request->validate([
                'watercom_stock_id' => 'required',
                'name' => 'required',
                'unit' => 'required',
                'volume' => 'required',
                'measure' => 'required',
                'price' => 'required',
                'type' => 'required',
            ]);

            $attributes['status'] = true;
            $product = WatercomProduct::create($attributes);
            ActivityLogHelper::addToLog('Added product ' . $product->name);

            $stock->products()->save($product);
        } catch (QueryException $th) {
            notify()->error('WatercomProduct "' . $request->name . '" with quantity of "' . $request->quantity . '" already exists.');
            return back();
        }
        notify()->success('You have successful added a product');

        return Redirect::back();
    }

    // EDIT PRODUCT
    public function putWatercomProduct(Request $request, WatercomProduct $product)
    {
        $stock = WatercomStock::findOrFail($request->watercom_stock_id);

        try {
            $attributes = $request->validate([
                'volume' => 'required',
                'unit' => 'required',
                'measure' => 'required',
                'price' => 'required',
                'type' => 'required',
            ]);

            $attributes['watercom_stock_id'] = $stock->id;
            $attributes['name'] = $stock->name;

            $product->update($attributes);
            ActivityLogHelper::addToLog('Updated product ' . $product->name);
        } catch (QueryException $th) {
            notify()->error('Product "' . $request->name . '" with volume of "' . $request->quantity . '" already exists.');
            return back();
        }
        notify()->success('You have successful edited an product');
        return redirect()->back();
    }

    // TOGGLE PRODUCT STATUS
    public function toggleStatus(Request $request, WatercomProduct $product)
    {

        $attributes = $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $product->update($attributes);
        ActivityLogHelper::addToLog('Switched product ' . $product->name . ' status ');

        notify()->success('You have successfully updated product status');
        return back();
    }

    // DELETE PRODUCT
    public function deleteWatercomProduct(WatercomProduct $product)
    {

        $itsName = $product->name;
        $product->delete();
        ActivityLogHelper::addToLog('Deleted product ' . $itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
