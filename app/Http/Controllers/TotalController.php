<?php

namespace App\Http\Controllers;

use App\Models\APPROVISIONNEMENT;
use App\Models\commune;
use App\Models\regisseur;
use App\Models\total;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(): Application|Factory|View
   {
       $communes = ['rural', 'urban'];
       $annees = [];
       $typeRegisseur = ['approvisionnement', 'versement' ,'chez_tp'];
       for ($i=2023;$i<Carbon::now()->year+1;$i++){
           $annees[]=$i;
       }

       return view('TotalRecap.choix',
           [
                'communes' => $communes,
               'typeRegisseur' => $typeRegisseur,
               'annees' => $annees
           ]);
   }
    public function display(Request $request): Application|Factory|View
    {
        $values = ['0.5', '1', '2', '5', '50'];
        $table_mois = array_fill_keys([
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ], array_fill_keys($values, 0));

        $table_total_mois = array_fill_keys($values, 0);
        $table_total = array_fill_keys($values, 0);

        switch ($request->typeRegisseur) {
            case 'approvisionnement':
                $table_name = 'a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s';
                $typeRegisseur = 'approvisionnement';
                break;
            case 'versement':
                $table_name = 'v_e_r_s_e_m_e_n_t_s';
                $typeRegisseur = 'versement';
                break;
            case 'chez_tp':
                $table_name = 'chez__t_p_s';
                $typeRegisseur = 'chez_tp';
                break;
        }

        $annee = $request->annee;
        $commune = commune::select('id')
            ->where('region', $request->region)
            ->get();

        foreach ($commune as $comu) {
            $regisseurs = $comu->regisseurs()->get();

            foreach ($regisseurs as $regi) {
                $table = DB::table($table_name)
                    ->where('regisseur_id', $regi->id)
                    ->where('annee', $annee)
                    ->orderBy('id')
                    ->get();

                foreach ($table as $mois) {
                    foreach ($values as $value) {
                        $table_mois[$mois->mois][$value] += $mois->$value;
                    }
                }

                $tableT[$regi->id] = DB::table('totals')
                    ->where('regisseur_id', $regi->id)
                    ->where('type', $typeRegisseur)
                    ->where('annee', $annee)
                    ->orderBy('id')
                    ->get();

                $tableTotal = DB::table('totals')
                    ->where('regisseur_id', $regi->id)
                    ->where('annee', $annee - 1)
                    ->orderBy('type')
                    ->get();


                if ($tableTotal->count() == 2) {
                    foreach ($values as $value) {
                        $table_total[$value] += $tableTotal[0]->$value - $tableTotal[1]->$value;
                    }
                }
            }
        }

        foreach ($tableT as $item) {
            foreach ($item as $value) {
                foreach ($values as $val) {
                    $table_total_mois[$val] += $value->$val + $table_total[$val];
                }
            }
        }

        return view('TotalRecap.RecapeTotal', [
            'annee' => $annee,
            'table_total' => $table_total,
            'table_total_mois' => $table_total_mois,
            'values' => $values,
            'typeRegisseur' => $typeRegisseur,
            'table_mois' => $table_mois
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store($totalAnnuel, $typeRegisseur, $annee, $IDRegisseur)
    {


        $reste = ['0.5' => 0, '1' => 0, '2' => 0, '5' => 0, '50' => 0];
        $resteTP=['0.5'=>0, '1'=>0, '2'=>0, '5'=>0, '50'=>0];
        $keysToFetch = ['0.5', 1, 2, 5, 50];
        $check = DB::table('totals')
            ->where('regisseur_id', $IDRegisseur)
            ->where('annee', $annee)
            ->where('type', $typeRegisseur)
            ->orderBy('id')
            ->get();
        $reprise = DB::table('totals')
            ->where('regisseur_id', $IDRegisseur)
            ->where('annee', $annee - 1)
            ->whereIn('type', ['approvisionnement', 'versement'])
            ->orderBy('id')
            ->get();

        if ($reprise->count() > 1) {
            $reste['0.5'] += ($reprise[0]->{'0.5'} ?? 0) - ($reprise[1]->{'0.5'} ?? 0);
            $reste['1'] += ($reprise[0]->{'1'} ?? 0) - ($reprise[1]->{'1'} ?? 0);
            $reste['2'] += ($reprise[0]->{'2'} ?? 0) - ($reprise[1]->{'2'} ?? 0);
            $reste['5'] += ($reprise[0]->{'5'} ?? 0) - ($reprise[1]->{'5'} ?? 0);
            $reste['50'] += ($reprise[0]->{'50'} ?? 0) - ($reprise[1]->{'50'} ?? 0);
        }

        if ($typeRegisseur == 'chez_tp') {

            $totalTP=DB::table('totals')
                ->where('regisseur_id', $IDRegisseur)
                ->where('annee', $annee-1)
                ->where('type','chez_tp')
                ->orderBy('id')
                ->get();

            $totalAPP=DB::table('totals')
                ->where('regisseur_id', $IDRegisseur)
                ->where('annee', $annee-1)
                ->where('type','approvisionnement')
                ->orderBy('id')
                ->get();


            $values = ['0.5', '1', '2', '5', '50'];
            foreach ($values as $value) {
                $resteTP[$value] += $totalTP->first()->{$value} ?? 0-$totalAPP->first()->{$value} ?? 0;
            }
        }
        if ($check->isEmpty()) {

            $var = total::create([
                'type' => $typeRegisseur,
                'annee' => $annee,
                'regisseur_id' => $IDRegisseur,
            ]);

            foreach ($keysToFetch as $key) {
                $newValue = $totalAnnuel[$key]+$reste[$key]+$resteTP[$key];
                $varId = $var->id;
                $sql = "UPDATE `totals` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                DB::statement($sql, [$newValue, now(), $varId]);
            }
        } else {
            foreach ($check as $item) {
                $var = total::find($item->id);
                $var->update([
                    'type' => $typeRegisseur,
                    'annee' => $annee,
                    'regisseur_id' => $IDRegisseur,
                ]);

                foreach ($keysToFetch as $key) {
                    $newValue = $totalAnnuel[$key]+$reste[$key]+$resteTP[$key];
                    $varId = $var->id;
                    $sql = "UPDATE `totals` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                    DB::statement($sql, [$newValue, now(), $varId]);
                }

            }
        }
    }



    /**
     * Display the specified resource.
     */
    public function show( $id,  $annee)
    {
        $regisseur=regisseur::find($id);
        $approv=['0.5'=>0, '1'=>0, '2'=>0, '5'=>0, '50'=>0];
        $versement=['0.5'=>0, '1'=>0, '2'=>0, '5'=>0, '50'=>0];
        $values = ['0.5', '1', '2', '5', '50'];
        $QUE = DB::table('totals')
            ->where('regisseur_id', $id)
            ->where('annee', $annee)
            ->orderBy('id')
            ->get();


        return view('/commune/Recape', [
            'name' => $regisseur->name,
            'total' => $QUE,
            'IDRegisseur' => $id,
            'values' => $values,
            'annee' => $annee,
        ]);
    }

    public function resteTP($id,$annee,$name)
    {
        $totalTP=DB::table('totals')
            ->where('regisseur_id', $id)
            ->where('annee', $annee)
            ->where('type','chez_tp')
            ->orderBy('id')
            ->get();

        $totalAPP=DB::table('totals')
            ->where('regisseur_id', $id)
            ->where('annee', $annee)
            ->where('type','approvisionnement')
            ->orderBy('id')
            ->get();

        $resteTP=['0.5'=>0, '1'=>0, '2'=>0, '5'=>0, '50'=>0];
        $values = ['0.5', '1', '2', '5', '50'];
        $sumTP=0;
        $sumAPP=0;


            foreach ($values as $value) {
                $sumAPP += $totalAPP->first()->{$value} ?? 0;
                $sumTP+= $totalTP->first()->{$value} ?? 0;
                $resteTP[$value] += $totalTP->first()->{$value} ?? 0-$totalAPP->first()->{$value} ?? 0;
            }


        return view('commune.TpReste',[

            'name'=>$name,
            'annee'=>$annee,
            'resteTP'=>$resteTP,
            'sumTP'=>$sumTP,
            'chezTp'=>$totalTP,
            'sumREG'=>$sumAPP,
             'chezREG'=>$totalAPP,
            'values'=>$values,
            ]
        );
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
