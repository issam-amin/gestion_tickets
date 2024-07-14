<?php

namespace App\Http\Controllers;

use App\Models\CU;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CuController extends Controller
{
    public function index(): View|Factory|Application
    {
        $cus = CU::select('cu_name')->groupBy('cu_name')->get();


            return view('Cu.index',
                [
                    'CUS'=> $cus
                ]);
    }
    public function show($cu_name)
    {
        $cu = CU::where('cu_name', $cu_name)->first();

        if (!$cu) {
            abort(404);
        }

        dd($cu->name_cu); // Debug output
        // $regisseurs = $cu->regisseur;
        // dd($regisseurs);
        // return view('cu.show', ['nom' => $cu, 'regisseurs' => $regisseurs]);
    }

}
