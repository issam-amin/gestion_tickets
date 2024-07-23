<?php

namespace App\Http\Controllers;

use App\Models\CR;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Application
    {
        $crs = CR::select('cr_name')->groupBy('cr_name')->get();


        return view('Cr.index',
            [
                'Communes'=> $crs
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

    public function show($cr_name)
    {
        $cr = CR::where('cr_name', $cr_name)->first();
        if ($cr) {
            $regisseurs = $cr->regisseur ?? []; // Ensure $regisseurs is an array
        } else {
            return abort(404, 'CR not found');
        }

        $typRegi = ['approvisionnement', 'versement', 'chez_tp'];
        $annees = range(2023, Carbon::now()->year);

        return view('cr.show', [
            'cr_name' => $cr_name,
            'nomCom' => $cr,
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
