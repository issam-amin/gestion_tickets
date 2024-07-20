<?php

namespace App\Http\Controllers;

use App\Models\CU;
use Carbon\Carbon;
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
        $cu=[];$regisseurs=[];$typRegi=[];$annees=[];

        $cu = CU::where('cu_name', $cu_name)->first();
        if ($cu) {
            $regisseurs = $cu->regisseur;

        } else {
            dd('CU not found');
        }
        $typRegi=['approvisionnement','versement','chez_tp'];
        for ($i=2023;$i<Carbon::now()->year+1;$i++){
            $annees[]=$i;
        }

        // $regisseurs = $cu->regisseur;
        // dd($regisseurs);
        return view('cu.show',
            [
                'cu_name'=>$cu_name,
                'nomCom' => $cu,
                'regisseurs' => $regisseurs,
                'typeRegisseur' => $typRegi,
                'annees' => $annees
            ]);
    }
    public function tableau($cu_name, $name)
    {
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];

        return view('cu.tableau', [
            'months' => $months,
            'cu_name' => $cu_name,
            'name' => $name
        ]);
    }

}
