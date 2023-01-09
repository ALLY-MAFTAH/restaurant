<?php

namespace Modules\Watercom\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Watercom\Entities\WatercomProduct;
use Modules\Watercom\Entities\WatercomSale;
use Modules\Watercom\Entities\WatercomStock;

class WatercomSaleController extends Controller
{

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $filteredStockName = "";
        $filteredDate = Carbon::now('GMT+3')->toDateString();
        $selectedStockName = "";
        $selectedDate = "";

        $filteredStockName = $request->get('filteredStockName', "All WatercomProducts");
        $filteredDate = $request->get('filteredDate', "All Days");

        if ($filteredDate == null) {
            $filteredDate = "All Days";
        }
        $filteredStock = WatercomStock::where([ 'name' => $filteredStockName])->first();

        if ($filteredDate != "All Days" && $filteredStockName != "All WatercomProducts") {
            $sales = WatercomSale::where(['watercom_stock_id' => $filteredStock->id, 'date' => $filteredDate])->latest()->get();
        } elseif ($filteredDate == "All Days" && $filteredStockName != "All WatercomProducts") {
            $sales = WatercomSale::where(['watercom_stock_id' => $filteredStock->id])->latest()->get();
        } elseif ($filteredStockName == "All WatercomProducts" && $filteredDate != "All Days") {
            $sales = WatercomSale::where('date', $filteredDate)->latest()->get();
        } else {
            $sales = WatercomSale::latest()->get();
        }
        $selectedStockName = $filteredStockName;
        $selectedDate = $filteredDate;

        $stocks = WatercomStock::where('quantity', '>', 0)->get();
        $allStocks = WatercomStock::all();
        $products = WatercomProduct::where(['status' => 1])->get();
        // dd($filteredStockName);

        return view('watercom::sales.index', compact('sales', 'products', 'stocks', 'allStocks', 'filteredDate', 'filteredStockName', 'selectedStockName', 'selectedDate'));
    }

    // SELL PRODUCT
    public function sellWatercomProduct(Request $request, WatercomProduct $product)
    {
        $length = $request->iteration;
        $totalAmount = 0;
        for ($j = 0; $j < $length; $j++) {
            $totalAmount += $product->quantity;
        }
        try {
            for ($i = 0; $i < $length; $i++) {

                $stock = WatercomStock::where('module','watercom')->findOrFail($product->watercom_stock_id);
                if ($product->quantity <= $stock->quantity) {
                    $newQuantity = $stock->quantity - $product->quantity;
                    $stock->update([
                        'quantity' => $newQuantity,
                    ]);
                    $stock->save();
                } else {
                    notify()->error("Sorry! You can't sell " . $totalAmount . " " . $product->unit . " of " . $product->stock->name . ". Amount remained is " . $stock->quantity . " " . $product->unit);
                    return back();
                }

                // Record sell
                $attributes =  [
                    'name' => $product->stock->name,
                    'unit' => $product->unit,
                    'price' => $product->price,
                    'watercom_stock_id' => $product->watercom_stock_id,
                    'quantity' => $product->quantity,
                    'container' => $product->container,
                    'user_name' => Auth::user()->name,
                    'product_id' => $product->id,
                    'user_id' => Auth::user()->id,
                    'date' => Carbon::now('GMT+3')->toDateString(),
                    'status' => true,
                ];
                $sell = WatercomSale::create($attributes);
                $stock->sales()->save($sell);
                ActivityLogHelper::addToLog('Sold product ' . $stock->name);
            }
        } catch (\Throwable $th) {
            notify()->error('Oops! Something went wrong');
            return back();
        }
        notify()->success('You have successful sold ' . $sell->name);
        return Redirect::back();
    }
}
