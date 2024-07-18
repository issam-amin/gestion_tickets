<?php

namespace App\Http\Controllers;

use App\Models\APPROVISIONNEMENT;
use App\Models\regisseur;
use App\Models\VERSEMENT;
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
                $total=DB::table('totals')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->where('type','approvisionnement')
                    ->orderBy('id')
                    ->get();
                $reprise=DB::table('totals')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab-1)
                    ->orderBy('id')
                    ->get();
                //dd($reprise);
                break;
            case 'versement':
                $donnes=DB::table('v_e_r_s_e_m_e_n_t_s')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->orderBy('id')
                    ->get();
                $total=DB::table('totals')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab)
                    ->where('type','versement')
                    ->orderBy('id')
                    ->get();
                $reprise=DB::table('totals')
                    ->where('regisseur_id',$request->regisseurs)
                    ->where('annee',$request->anneetab-1)
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
            'total' => $total,
            'reprise' => $reprise,
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
    public function store(Request $request, $typeRegisseur,$annee, $IDRegisseur)
    {
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];

if ($typeRegisseur=='approvisionnement'){
        $check=DB::table('a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s')
            ->where('regisseur_id',$IDRegisseur)
            ->where('annee',$annee)
            ->orderBy('id')
            ->get();
        if($check->count()!=0 ){
            foreach ($check as $month) {
                $sum=0;
                foreach ($request[$month->mois] as $coeff => $value) {
                    $sum += doubleval($value)*doubleval($coeff);
                }
               // dd($sum);
                $sums[$month->mois] = $sum;

               $var= APPROVISIONNEMENT::find($month->id) ;
                   $var->update([

                      'Somme' => $sum,

                      '1' => $request[$month->mois]['1'],
                      '2' => $request[$month->mois]['2'],
                      '5' => $request[$month->mois]['5'],
                      '50' => $request[$month->mois]['50'],

                  ]);
                $racho = '0.5';
                $newValue = $request[$month->mois][$racho];
                $varId = $var->id;
                $sql = "UPDATE `a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s` SET `$racho` = ?, `updated_at` = ? WHERE `id` = ?";
                DB::statement($sql, [$newValue, now(), $varId]);
            }
        }
        else{
            foreach ($months as $month) {
                $sum=0;
                foreach ($request[$month] as $coeff => $value) {
                    $sum += doubleval($value)*doubleval($coeff);
                }
                $sums[$month] = $sum;

               $var= Approvisionnement::create([
                    'mois' => $month,
                    'annee' => $annee,
                    'Somme' => $sum,

                    '1' => $request[$month]['1'],
                    '2' => $request[$month]['2'],
                    '5' => $request[$month]['5'],
                    '50' => $request[$month]['50'],
                    'regisseur_id' => $IDRegisseur,
                ]);
                $racho = '0.5';
                $newValue = $request[$month][$racho];
                $varId = $var->id;
                $sql = "UPDATE `a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s` SET `$racho` = ?, `updated_at` = ? WHERE `id` = ?";
                DB::statement($sql, [$newValue, now(), $varId]);


            }
        }
}
elseif ($typeRegisseur=='versement'){
    $check=DB::table('v_e_r_s_e_m_e_n_t_s')
        ->where('regisseur_id',$IDRegisseur)
        ->where('annee',$annee)
        ->orderBy('id')
        ->get();
    if($check->count()!=0 ){
        foreach ($check as $month) {
            $sum=0;
            foreach ($request[$month->mois] as $coeff => $value) {
                $sum += doubleval($value)*doubleval($coeff);
            }
            // dd($sum);
            $sums[$month->mois] = $sum;

            $var= VERSEMENT::find($month->id) ;
            $var->update([

                'Somme' => $sum,

                '1' => $request[$month->mois]['1'],
                '2' => $request[$month->mois]['2'],
                '5' => $request[$month->mois]['5'],
                '50' => $request[$month->mois]['50'],

            ]);
            $racho = '0.5';
            $newValue = $request[$month->mois][$racho];
            $varId = $var->id;
            $sql = "UPDATE `v_e_r_s_e_m_e_n_t_s` SET `$racho` = ?, `updated_at` = ? WHERE `id` = ?";
            DB::statement($sql, [$newValue, now(), $varId]);
        }
    }
    else{
        foreach ($months as $month) {
            $sum=0;
            foreach ($request[$month] as $coeff => $value) {
                $sum += doubleval($value)*doubleval($coeff);
            }
            $sums[$month] = $sum;

            $var= VERSEMENT::create([
                'mois' => $month,
                'annee' => $annee,
                'Somme' => $sum,

                '1' => $request[$month]['1'],
                '2' => $request[$month]['2'],
                '5' => $request[$month]['5'],
                '50' => $request[$month]['50'],
                'regisseur_id' => $IDRegisseur,
            ]);
            $racho = '0.5';
            $newValue = $request[$month][$racho];
            $varId = $var->id;
            $sql = "UPDATE `v_e_r_s_e_m_e_n_t_s` SET `$racho` = ?, `updated_at` = ? WHERE `id` = ?";
            DB::statement($sql, [$newValue, now(), $varId]);


        }
    }
}
        $totalController = new TotalController();
        $totalController->store($request, $typeRegisseur, $annee, $IDRegisseur);

        $commune=regisseur::find($IDRegisseur)->cu()->first();
        return redirect('/Cu/'.$commune->cu_name);
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
