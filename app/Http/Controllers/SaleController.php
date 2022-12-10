<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SaleController extends Controller
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
        $sales = Sale::latest()->get();
        $items = Item::where('status', 1)->get();
        $products = Product::where('status', 1)->get();

        return view('sales.index', compact('sales', 'products', 'items'));
    }

    // SELL PRODUCT
    public function sellProduct(Request $request, Product $product)
    {
        $length = $request->iteration;
        $totalAmount = 0;
        for ($j = 0; $j < $length; $j++) {
            $totalAmount += $product->quantity;
        }

        try {
            for ($i = 0; $i < $length; $i++) {

                $item = Item::findOrFail($product->item_id);
                if ($product->quantity <= $item->quantity) {
                    $newQuantity = $item->quantity - $product->quantity;
                    $item->update([
                        'quantity' => $newQuantity,
                    ]);
                    $item->save();
                } else {
                    notify()->error("Sorry! You can't sell " . $totalAmount . " " . $product->unit . " of " . $product->item->name . ". Amount remained is " . $item->quantity . " " . $product->unit);
                    return back();
                }

                // Record sell
                $attributes['product_id'] = $product->id;
                $attributes['user_id'] = Auth::user()->id;
                $attributes['status'] = true;
                $sell = Sale::create($attributes);
            }
        } catch (\Throwable $th) {
            notify()->error('Oops! Something went wrong');
            return back();
        }
        notify()->success('You have successful sell ' . $product->item->name);
        return Redirect::back();
    }
}
