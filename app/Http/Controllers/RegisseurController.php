<?php

namespace App\Http\Controllers;

use App\Models\APPROVISIONNEMENT;
use App\Models\CU;
use App\Models\regisseur;
use App\Models\Total;
use App\Models\VERSEMENT;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

class RegisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory|Application
    {

        if (!empty($request->regisseurs)) {
            $regisseur=regisseur::find($request->regisseurs);
        }
        $cuName= $regisseur->cu()->first()->cu_name;
        $values = [0.5, 1, 2, 5, 50];
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];
         $annee=$request->anneetab;
         $idregisseur=$request->regisseurs;
         $typeregisseur=$request->typeRegi;
        switch ($request->typeRegi) {
            case 'approvisionnement':
                $table='a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s';
                break;
            case 'versement':
                $table='v_e_r_s_e_m_e_n_t_s';
                break;
            case 'chez_tp':
                $table='chez__t_p_s';
                break;
        }
        $donnes=DB::table($table)
            ->where('regisseur_id',$idregisseur)
            ->where('annee',$annee)
            ->orderBy('id')
            ->get();
        $total=DB::table('totals')
            ->where('regisseur_id',$idregisseur)
            ->where('annee',$annee)
            ->where('type',$typeregisseur)
            ->orderBy('id')
            ->get();
        $reprise=DB::table('totals')
            ->where('regisseur_id',$idregisseur)
            ->where('annee',$annee-1)
            ->orderBy('id')
            ->get();

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
    public function show(Request $request, $cu_name)
    {

        $table_total = ['0.5' => 0, '1' => 0, '2' => 0, '5' => 0, '50' => 0];
        $selectedYear = $request->input('anneetab1');
        $values = ['0.5','1', '2', '5', '50'];
        $total_appro = [];
        $total_ver = [];
        $cu = CU::where('cu_name', $cu_name)->first();
        $idregis = $cu->regisseur->pluck('id');


        /*$tableTotal=DB::table('totals')
            ->where('regisseur_id',$id)
            ->where('annee',$selectedYear)
            ->orderBy('type')
            ->get();

        if($tableTotal->count()==2)
        {
            $table_total['0.5'] += $tableTotal[0]->{'0.5'} - $tableTotal[1]->{'0.5'};
            $table_total['1'] += $tableTotal[0]->{'1'} - $tableTotal[1]->{'1'};
            $table_total['2'] += $tableTotal[0]->{'2'} - $tableTotal[1]->{'2'};
            $table_total['5'] += $tableTotal[0]->{'5'} - $tableTotal[1]->{'5'};
            $table_total['50'] += $tableTotal[0]->{'50'} - $tableTotal[1]->{'50'};

        }*/


//Approvisionnement
        foreach ($idregis as $id) {
            foreach ($values as $value) {
                $column = "`" . $value . "`";
                $total_appro[$id][$value] = DB::table('totals')
                    ->where('regisseur_id', $id)
                    ->where('annee', $selectedYear)
                    ->where('type', 'approvisionnement')
                    ->sum(DB::raw($column));
            }
        }
        foreach ($values as $value) {
            $total_sum = 0;
            foreach ($total_appro as $id => $appro) {
                if (isset($appro[$value])) {

                    $total_sum += $appro[$value];
                }
            }
            $total_appro['total'][$value] = $total_sum;
        }
// Versement
        foreach ($idregis as $id) {
            foreach ($values as $value) {
                $column = "`" . $value . "`";
                $total_ver[$id][$value] = DB::table('totals')
                    ->where('regisseur_id', $id)
                    ->where('annee', $selectedYear)
                    ->where('type', 'versement')
                    ->sum(DB::raw($column));
            }
        }
        foreach ($values as $value) {
            $total_sum = 0;
            foreach ($total_ver as $id => $ver) {
                if (isset($ver[$value])) {

                    $total_sum += $ver[$value];
                }
            }
            $total_ver['total'][$value] = $total_sum;
        }

        //RESTE




                $table_total['0.5'] += $total_appro['total']['0.5']- $total_ver['total']['0.5'];
                $table_total['1'] += $total_appro['total']['1'] - $total_ver['total']['1'];
                $table_total['2'] += $total_appro['total']['2'] - $total_ver['total']['2'];
                $table_total['5'] += $total_appro['total']['5'] - $total_ver['total']['5'];
                $table_total['50'] += $total_appro['total']['50'] - $total_ver['total']['50'];



        return view('Cu.totalRecap', [
                'table_total'=>  $table_total,
            'values' => $values,
            'cu_name' => $cu_name,
            'total_appro' => $total_appro,
            'total_ver' => $total_ver,
            'selectedYear' => $selectedYear,
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
