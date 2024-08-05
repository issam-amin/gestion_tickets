<?php

namespace App\Http\Controllers;

use App\Models\commune;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        public function restToT($region, $typeRegisseur, $annee){
            $values = ['0.5', 1, 2, 7, 5, 50];
            $table_total_app = array_fill_keys($values, 0);
            $table_total_ver = array_fill_keys($values, 0);
            $table_total_tp = array_fill_keys($values, 0);
            $reste=array_fill_keys($values, 0);
            $commune = commune::where('region', $region)->get();
            foreach ($commune as $comu) {
                $regisseurs = $comu->regisseurs()->get();
                foreach ($regisseurs as $regi){
                    $tableT[$regi->id] = DB::table('totals')
                        ->where('regisseur_id', $regi->id)
                        ->where('type', 'approvisionnement')
                        ->where('annee', $annee)
                        ->get();
                }
                if ($typeRegisseur=='approvisionnement' || $typeRegisseur=='versement'){

                    //ligne total
                    foreach ($regisseurs as $regi) {

                        $tableA[$regi->id] = DB::table('totals')
                            ->where('regisseur_id', $regi->id)
                            ->where('type', 'versement')
                            ->where('annee', $annee)
                            ->get();
                        //reste
                       // $reste[$regi->id]

                           $recap = DB::table('recaps')
                                ->where('regisseur_id', $regi->id)
                                ->where('annee', $annee)
                                ->where('type', 'approvisionnement')
                                ->get();
                           if(!empty($recap)){
                               $reste=['0.5'=>$reste['0.5']+$recap[0]->{'0.5'},1=>$reste[1]+$recap[0]->{1},2=>$reste[2]+$recap[0]->{2},
                                   7=>$reste[7]+$recap[0]->{7},5=>$reste[5]+$recap[0]->{5},50=>$reste[50]+$recap[0]->{50}];

                           }

                    }

            }
            elseif($typeRegisseur=='chez_tp'){
                foreach ($regisseurs as $regi){
                    $tableA[$comu->id] = DB::table('total_tps')
                        ->where('commune_id', $comu->id)
                        ->where('type', 'chez_tp')
                        ->where('annee', $annee)
                        ->orderBy('id')
                        ->get();
                }
                    //reste



                    $recap = DB::table('recap_tps')
                        ->where('commune_id', $comu->id)
                        ->where('annee', $annee)
                        ->where('type', $typeRegisseur)
                        ->get();
                    if(!empty($recap)){
                        $reste=['0.5'=>$reste['0.5']+$recap[0]->{'0.5'},1=>$reste[1]+$recap[0]->{1},2=>$reste[2]+$recap[0]->{2},
                            7=>$reste[7]+$recap[0]->{7},5=>$reste[5]+$recap[0]->{5},50=>$reste[50]+$recap[0]->{50}];

                    }


            }
            }
            if ($typeRegisseur=='approvisionnement' || $typeRegisseur=='versement'){

                //ligne APP
                foreach ($tableT as $item) {
                    foreach ($item as $value) {
                        foreach ($values as $val) {
                            $table_total_app[$val] += $value->$val;
                        }
                    }
                }
                //ligne tp
                foreach ($tableA as $item) {
                    foreach ($item as $value) {
                        foreach ($values as $val) {
                            $table_total_ver[$val] += $value->$val;
                        }
                    }
                }
            }
            elseif ($typeRegisseur=='chez_tp'){
                //RESTE APP
               /* foreach ($values as $value) {
                    $total_sum = 0;
                    foreach ($reste as $comu->id => $appro) {
                        if (isset($appro[$value])) {

                            $total_sum += $appro[$value];
                        }
                    }
                    $reste['total'][$value] = $total_sum/$value;
                }*/
                //ligne APP
                foreach ($tableT as $item) {
                    foreach ($item as $value) {
                        foreach ($values as $val) {
                            $table_total_app[$val] += $value->$val;
                        }
                    }
                }
                //ligne VER
                foreach ($tableA as $item) {
                    foreach ($item as $value) {
                        foreach ($values as $val) {
                            $table_total_tp[$val] += $value->$val;
                        }
                    }
                }
            }
            //dd(array_sum($table_total_app),array_sum($table_total_tp),array_sum($reste['total']));
            return view('TotalRecap.reste',
                [
                    'region' => $region,
                    'annee' => $annee,
                    'values' => $values,
                    'typeRegisseur' => $typeRegisseur,
                    'table_total_app' => $table_total_app,
                    'table_total_ver' => $table_total_ver,
                    'table_total_tp' => $table_total_tp,
                    'reste' => $reste
                ]);
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


        $typRegi=['approvisionnement','versement'];
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
