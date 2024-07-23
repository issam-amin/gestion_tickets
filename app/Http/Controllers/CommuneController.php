<?php

namespace App\Http\Controllers;

use App\Models\commune;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type)
    {

        $commune = commune::where('region', $type)->get();

        return view('commune.index',
            [
                'Communes'=> $commune
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($region, $id)
    {

        $commune=[];$regisseurs=[];$typRegi=[];$annees=[];

        $commune =commune::find($id);

        if ($commune) {
            $regisseurs = $commune->regisseurs()->get();

        } else {
            dd('CU not found');
        }



        $typRegi=['approvisionnement','versement','chez_tp'];
        for ($i=2023;$i<Carbon::now()->year+1;$i++){
            $annees[]=$i;
        }

        // $regisseurs = $commune->regisseur;
        // dd($regisseurs);
        return view('commune.show',
            [
                'nomCom' => $commune,
                'regisseurs' => $regisseurs,
                'typeRegisseur' => $typRegi,
                'annees' => $annees
            ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
