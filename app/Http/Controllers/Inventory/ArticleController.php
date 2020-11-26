<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Logic\Inventory\Article as ArticleLogic;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('inventory.index');
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
          'name' => 'required|string',
          'barcode' => 'required|string',
          'status'  => 'required|integer'
        ], [
          'name.required' => 'El Nombre es obligatorio',
          'barcode.required' => 'El Código de barras es obligatorio',
          'status.required' => 'El estado es obligatorio'
        ]);

        if (!$Validator->fails()) {
            $A = ArticleLogic::Store($request->input('name'), $request->input('barcode'), $request->input('status'));

            if (isset($A->id)) {
                return Response()->json(['m' => 'Se ha guardado correctamente'], 200);
            }

            return Response()->json(['m' => 'Ocurrió un error intente de nuevo más tarde'], 422);
        }

        return Response()->Json(['errors' => $Validator->errors()], 422);
    }
}
