<?php

namespace App\Http\Controllers;

use App\Models\APPROVISIONNEMENT;
use App\Models\regisseur;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory|Application
    {
        //dd($request->all());
        $regisseur=regisseur::find($request->regisseurs);
        $cuName= $regisseur->cu()->first()->cu_name;
       //dd( $regisseur->cu()->first()->cu_name);
        $values = [0.5, 1, 2, 5, 50];
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
                    ->orderBy('id')
                    ->get();
                break;
            case 'versement':
                $donnes=DB::table('v_e_r_s_e_m_e_n_t_s')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->orderBy('id')
                    ->get();
                break;
            case 'chez_tp':
                $donnes=DB::table('chez__t_p_s')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->orderBy('id')
                    ->get();
                break;
        }



        return view('/cu/'.$request->typeRegi, [
            'IDRegisseur' => $request->regisseurs,
            'typeRegisseur' => $request->typeRegi,
            'values' => $values,
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


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $annee, $IDRegisseur)
    {
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];

        $check=DB::table('a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s')
            ->where('regisseur_id',$request->regisseurs)
            ->where('annee',$request->anneetab)
            ->orderBy('id')
            ->get();

        if($check){

            foreach ($check as $month) {

                $coeff=['0.5'=>'0.5','1'=>'1','2'=>'2','5'=>'5','50'=>'50'];
                    $sum = doubleval($month->$coeff['0.5'])*0.5
                        + doubleval($month->$coeff['1'])*1
                        + doubleval($month->$coeff['2'])*2
                        + doubleval($month->$coeff['5'])*5
                        + doubleval($month->$coeff['50'])*50;

dd($sum);
              /*$month  updat([
                    'mois' => $month,
                    'annee' => $annee,
                    'Somme' => $sum,
                    '0.5' => $request[$month]['0.5'],
                    '1' => $request[$month]['1'],
                    '2' => $request[$month]['2'],
                    '5' => $request[$month]['5'],
                    '50' => $request[$month]['50'],
                    'regisseur_id' => $IDRegisseur,
                ]);*/

            }
        }
        else{
            foreach ($months as $month) {
                $sum=0;
                foreach ($request[$month] as $coeff => $value) {
                    $sum += doubleval($value)*doubleval($coeff);
                }

                Approvisionnement::create([
                    'mois' => $month,
                    'annee' => $annee,
                    'Somme' => $sum,
                    '0.5' => $request[$month]['0.5'],
                    '1' => $request[$month]['1'],
                    '2' => $request[$month]['2'],
                    '5' => $request[$month]['5'],
                    '50' => $request[$month]['50'],
                    'regisseur_id' => $IDRegisseur,
                ]);

            }
        }




       // return redirect()->back();
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
