<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Repositories\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('product');
    }

    public function dt(Request $request)
    {
        return Datatables::of(Product::query())->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric',
        ]);

        if (!$validator->fails()) {

            $Product = Product::create([
                'name' => $request->input('name'),
                'stock' => $request->input('stock'),
                'price' => $request->input('price'),
            ]);

            if (!is_null($Product)) {
                return Response()->json(['m' => 'Product has been created'], 200);
            }

            return Response()->json(['m' => 'Error, try again later'], 422);

        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => 'required|integer',
            'name' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric',
        ]);

        if (!$validator->fails()) {
            $Product = Product::Find($request->input('id'));
            if (isset($Product->id)){
                $Product->name = $request->input('name');
                $Product->stock = $request->input('stock');
                $Product->price = $request->input('price');
                $Product->Save();
                return Response()->json(['m' => 'Product has been updated'], 200);
            }

            return Response()->json(['m' => 'Error, try again later'], 422);

        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }


    public function get(Request $request)
    {

    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer',
        ]);

        if (!$validator->fails()) {

            Product::where('id', $request->input('id'))->delete();
            return Response()->json(['m' => 'Product has been deleted'], 200);
        }

        return Response()->json(['errors' => $validator->errors()], 422);
    }
}

