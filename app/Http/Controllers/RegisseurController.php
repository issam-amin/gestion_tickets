<?php

namespace App\Http\Controllers;

use App\Models\regisseur;
use Illuminate\Http\Request;

class RegisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $regisseur=regisseur::find($id);
        $cuName= $regisseur->cu()->first()->cu_name;
       // dd( $regisseur->cu()->first()->cu_name);
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];

        return view('cu.tableau', [
            'months' => $months,
            'name' => $regisseur->name,
            'cu_name' => $cuName,
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
    public function show(string $id)
    {
        //
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
