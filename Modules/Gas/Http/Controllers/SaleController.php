<?php

namespace Modules\Icecream\Http\Controllers;
use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
    public function index(Request $request)
    {

        $filteredItemName = "";
        $filteredDate = Carbon::now('GMT+3')->toDateString();
        $selectedItemName = "";
        $selectedDate = "";

        $filteredItemName = $request->get('filteredItemName', "All Products");
        $filteredDate = $request->get('filteredDate', "All Days");

        if ($filteredDate == null) {
            $filteredDate = "All Days";
        }
        $filteredItem = Item::where('name', $filteredItemName)->first();

        if ($filteredDate != "All Days" && $filteredItemName != "All Products") {
            $sales = Sale::where(['item_id' => $filteredItem->id, 'date' => $filteredDate])->latest()->get();
        } elseif ($filteredDate == "All Days" && $filteredItemName != "All Products") {
            $sales = Sale::where('item_id', $filteredItem->id)->latest()->get();
        } elseif ($filteredItemName == "All Products" && $filteredDate != "All Days") {
            $sales = Sale::where('date', $filteredDate)->latest()->get();
        } else {
            $sales = Sale::latest()->get();
        }
        $selectedItemName = $filteredItemName;
        $selectedDate = $filteredDate;

        $items = Item::where('quantity', '>', 0)->get();
        $allItems = Item::all();
        $products = Product::where('status', 1)->get();
        // dd($filteredItemName);

        return view('icecream::sales.index', compact('sales', 'products', 'items', 'allItems', 'filteredDate', 'filteredItemName', 'selectedItemName', 'selectedDate'));
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
                $attributes =  [
                    'name' => $product->item->name,
                    'unit' => $product->unit,
                    'price' => $product->price,
                    'item_id' => $product->item_id,
                    'quantity' => $product->quantity,
                    'container' => $product->container,
                    'user_name' => Auth::user()->name,
                    'product_id' => $product->id,
                    'user_id' => Auth::user()->id,
                    'date' => Carbon::now('GMT+3')->toDateString(),
                    'status' => true,
                ];
                $sell = Sale::create($attributes);
                $item->sales()->save($sell);
                ActivityLogHelper::addToLog('Sold product '.$item->name);

            }
        } catch (\Throwable $th) {
            notify()->error('Oops! Something went wrong');
            return back();
        }
        notify()->success('You have successful sell ' . $sell->name);
        return Redirect::back();
    }
}
