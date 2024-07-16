<?php

namespace App\Http\Controllers;

use App\Models\regisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //dd($request->all());

        $regisseur=regisseur::find($request->regisseurs);
        $cuName= $regisseur->cu()->first()->cu_name;
       //dd( $regisseur->cu()->first()->cu_name);
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];
       // dd($request->typeRegi);
        switch ($request->typeRegi) {
            case 'approvisionnement':
                $donnes=DB::table('a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->get();
                break;
            case 'versement':
                $donnes=DB::table('v_e_r_s_e_m_e_n_t_s')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->get();
                break;
            case 'chez_tp':
                $donnes=DB::table('chez__t_p_s')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->get();
                break;
        }
       // dd("cu".$request->typeRegi);
        return view('/cu/'.$request->typeRegi, [
            'typeRegisseur' => $request->typeRegi,
            'months' => $months,
            'name' => $regisseur->name,
            'cu_name' => $cuName,
            'donnes' => $donnes,
            'annee' => $request->anneetab,
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
        $request->validate([
            'name' => 'required',
            'cu_id' => 'required',
        ]);
        // request()->validate([
        //            'first_name' =>[ 'required','min:3'],
        //            'last_name' => 'required',
        //            /*'email' => 'required|email',*/
        //        ]);
        //        names::create([
        //            'first_name'=> request('first_name'),
        //            'last_name'=> request('last_name'),
        //            'email'=> request('email'),
        //            'employee_id'=>1
        //        ]);
        //        return redirect('/cu');
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
