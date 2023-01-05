<?php

namespace Modules\Icecream\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use App\Models\Stock;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{


    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stocks = Stock::where('module', 'icecream')->get();

        return view('icecream::stocks.index', compact('stocks'));
    }
    public function showStock(Request $request, Stock $stock)
    {

        return view('icecream::stocks.show', compact('stock'));
    }
    public function postStock(Request $request)
    {
        try {
            $attributes = $request->validate([
                'name' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'cost' => 'required',
            ]);

            $attributes['module'] = 'icecream';
            $attributes['status'] = true;
            $stock = Stock::create($attributes);
            ActivityLogHelper::addToLog(Auth::user()->name . ' Added stock ' . $stock->name);
        } catch (QueryException $th) {
            // dd($th);
            notify()->error('Failed to add stock "' . $request->name . '". It already exists.');
            return back();
        }
        notify()->success('You have successful added stock');

        return Redirect::back();
    }
    public function putStock(Request $request, Stock $stock)
    {
        try {
            $attributes = $request->validate([
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
        ActivityLogHelper::addToLog('Switched stock ' . $stock->name . ' status ');

        notify()->success('You have successfully updated stock status');
        return back();
    }
    public function deleteStock(Stock $stock)
    {

        $itsName = $stock->name;
        $stock->delete();
        ActivityLogHelper::addToLog('Deleted stock ' . $itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
