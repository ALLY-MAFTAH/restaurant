<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use App\Models\Stock;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
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
        $stocks = Stock::all();

        return view('stocks.index', compact('stocks'));
    }
    public function showStock(Request $request, Stock $stock)
    {
        $stocks = Stock::where('status', 1)->get();

        return view('stocks.show', compact('stock', 'stocks'));
    }
    public function postStock(Request $request)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'cost' => 'required',
            ]);

            $attributes['status'] = true;
            $stock = Stock::create($attributes);
            ActivityLogHelper::addToLog('Added stock ' . $stock->name);
        } catch (QueryException $th) {
            notify()->error('Failed to add stock "' . $request->name . '". It already exists.');
            return back();
        }
        notify()->success('You have successful added stock');

        return Redirect::back();
    }
    public function putStock(Request $request, Stock $stock)
    {
        try {
            $attributes = $this->validate($request, [
                'name' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'cost' => 'required',
            ]);

            $stock->update($attributes);
            ActivityLogHelper::addToLog('Updated stock ' . $stock->name);
        } catch (QueryException $th) {
            notify()->error('Failed to edit stock. "' . $request->name . '" already exists.');
            return back();
        }
        notify()->success('You have successful edited stock');
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Stock $stock)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $stock->update($attributes);
        ActivityLogHelper::addToLog('Switched stock '.$stock->name.' status ');

        notify()->success('You have successfully updated stock status');
        return back();
    }
    public function deleteStock( Stock $stock)
    {

        $itsName = $stock->name;
        $stock->delete();
        ActivityLogHelper::addToLog('Deleted stock '.$itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
