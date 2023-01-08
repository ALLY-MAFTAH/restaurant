<?php

namespace Modules\Watercom\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Watercom\Entities\WatercomProduct;
use Modules\Watercom\Entities\WatercomStock;

class WatercomStockController extends Controller
{


    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stocks = WatercomStock::latest()->get();

        return view('watercom::stocks.index', compact('stocks'));
    }
    public function showWatercomStock(Request $request, WatercomStock $stock)
    {

        return view('watercom::stocks.show', compact('stock'));
    }
    public function postWatercomStock(Request $request)
    {
        try {
            $attributes = $request->validate([
                'name' => 'required',
                'volume' => 'required',
                'unit' => 'required',
                'type' => 'required',
                'measure' => 'required',
                'cost' => 'required',
                'quantity' => 'required',
            ]);

            $attributes['status'] = true;
            $stock = WatercomStock::create($attributes);
            ActivityLogHelper::addToLog(Auth::user()->name . ' Added ' . $stock->name . ' to stock ');
        } catch (QueryException $th) {
            // dd($th);
            notify()->error('Failed to add "' . $request->name . '" stock. It already exists.');
            return back();
        }
        $request->request->add(['price' => $request->price,'stock_id'=>$stock->id]); //add request

        $watercomProduct = new WatercomProductController();
        $watercomProduct->postWatercomProduct($request);

        notify()->success('You have successful added ' . $request->quantity . ' ' . $request->unit . ' of ' . $request->name . ' to stock');

        return Redirect::back();
    }
    public function putWatercomStock(Request $request, WatercomStock $stock)
    {
        // dd($request->all);
        try {
            $attributes = $request->validate([
                'name' => 'required',
                'volume' => 'required',
                'unit' => 'required',
                'measure' => 'required',
                'type' => 'required',
                'cost' => 'required',
                'quantity' => 'required',
            ]);

            $stock->update($attributes);
            ActivityLogHelper::addToLog(Auth::user()->name . ' Updated ' . $stock->name . ' in stock ');
        } catch (QueryException $th) {
            notify()->error('Failed to edit stock. "' . $request->name . '" already exists.');
            return back();
        }
        $request->request->add(['price' => $request->price,'stock_id'=>$stock->id]); //add request

        $watercomProduct = new WatercomProductController();
        $watercomProduct->putWatercomProduct($request, $stock->product);
        notify()->success('You have successful edited stock');
        return redirect()->back();
    }
    public function toggleStatus(Request $request, WatercomStock $stock)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $stock->update($attributes);
        ActivityLogHelper::addToLog('Switched stock ' . $stock->name . ' status ');

        notify()->success('You have successfully updated stock status');
        return back();
    }
    public function deleteWatercomStock(WatercomStock $stock)
    {

        $itsName = $stock->name;
        $stock->delete();
        ActivityLogHelper::addToLog('Deleted stock ' . $itsName);

        $watercomProduct = new WatercomProductController();
        $watercomProduct->deleteWatercomProduct($stock->product);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
