<?php

namespace App\Http\Controllers;

use App\Models\APPROVISIONNEMENT;
use App\Models\Chez_TP;
use App\Models\commune;
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
use function PHPUnit\Framework\isEmpty;

class RegisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory|Application
    {

        $sommeAP = 0;
        $sommeTP = 0;
        if (!empty($request->regisseurs)) {
            $regisseur = regisseur::find($request->regisseurs);
        }

        $commune_Name = $regisseur->commune()->first()->name;

        $values = ['0.5', '1', '5','7', '2', '50'];
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];
        $annee = $request->anneetab;
        $idregisseur = $request->regisseurs;
        $typeregisseur = $request->typeRegi;

        switch ($request->typeRegi) {
            case 'approvisionnement':
                $table = 'a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s';
                break;
            case 'versement':
                $table = 'v_e_r_s_e_m_e_n_t_s';
                break;

        }

        $repriseAPP = DB::table('recaps')
            ->where('regisseur_id', $idregisseur)
            ->where('annee', $annee - 1)
            ->whereIn('type', ['approvisionnement'])
            ->orderBy('id')
            ->get();

        if ($repriseAPP->isNotEmpty()) {
            foreach ($values as $key) {
                $sommeAP += $repriseAPP[0]->{$key} ;
            }
        }



        /*$repriseTp =collect();
        if ($request->typeRegi == 'chez_tp') {
            $repriseTp = DB::table('recaps')
                ->where('regisseur_id', $idregisseur)
                ->where('annee', $annee - 1)
                ->whereIn('type', ['chez_tp'])
                ->orderBy('id')
                ->get();
            if ($repriseTp->isNotEmpty()) {
                foreach ($values as $key) {
                    $sommeTP += $repriseTp[0]->{$key} ;
                }
            }
        }*/



        // Colonne des mois pour chaque régisseur
        $donnes = DB::table($table)
            ->where('regisseur_id', $idregisseur)
            ->where('annee', $annee)
            ->orderBy('id')
            ->get();

        $total_annuel=DB::table('totals')
            ->where('regisseur_id', $idregisseur)
            ->where('annee', $annee)
            ->where('type', $typeregisseur)
            ->orderBy('id')
            ->first();
        $valeurtotal=0;

        if(!empty($total_annuel)){
            foreach ($values as $value) {
                $valeurtotal += $total_annuel->{$value};
            }
        }

        $valeurtotal = number_format($valeurtotal ?? 0, 2, ',', ' ');



        return view('/commune/'.$request->typeRegi, [

            'IDRegisseur' => $request->regisseurs,
            'typeRegisseur' => $request->typeRegi,
            'values' => $values,
            'months' => $months,
            'annee' => $request->anneetab,
            'name' => $regisseur->name,
            'commune_Name' => $commune_Name,
            'reste' => $repriseAPP,
            'donnes' => $donnes,
            'sommeTP' => $sommeTP,
            'sommeAP' => $sommeAP,
            'total_annuel' => $total_annuel,
            'valeurtotal'=>$valeurtotal,
        ]);
    }
    public function ChezTP(Request $request,$nom)
    {

        $repriseAPP = [];
        $repriseTp = collect();
        $sommeAP = 0;
        $sommeTP = 0;
        $annee = $request->annee;
        $values = ['0.5', 1, 5, 7, 2, 50];
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];
        $com = commune::where('name', $nom)->first();
// recap Tp
        $repriseTp = DB::table('recap_tps')
            ->where('commune_id', $com->id)
            ->where('annee', $annee - 1)
            ->orderBy('id')
            ->get();

        if (!$repriseTp->isEmpty()) {
            foreach ($values as $key) {
                $sommeTP += ($repriseTp[0]->{$key} ?? 0);
            }
        }

// recap APP
        $regis = $com->regisseurs()->get();
        foreach ($regis as $regi) {
            foreach ($values as $value) {
                $column = $value;
                $repriseAPP[$regi->id][$value] = DB::table('recaps')
                    ->where('regisseur_id', $regi->id)
                    ->where('annee', $annee - 1)
                    ->where('type', 'approvisionnement')
                    ->sum(DB::raw("`$column`"));
            }
        }

        foreach ($values as $value) {
            $total_sum = 0;
            foreach ($repriseAPP as $regisseurId => $appro) {
                if (isset($appro[$value])) {
                    $total_sum += $appro[$value];
                }
            }
            $repriseAPP['total'][$value] = $total_sum;
        }

        foreach ($values as $value) {
            $sommeAP += ($repriseAPP['total'][$value] ?? 0);
        }

// Colonne des mois pour chaque régisseur
        $donnes = DB::table('chez__t_p_s')
            ->where('commune_id', $com->id)
            ->where('annee', $annee)
            ->orderBy('id')
            ->get();

        $total_annuel = DB::table('total_tps')
            ->where('commune_id', $com->id)
            ->where('annee', $annee)
            ->orderBy('id')
            ->first();

        $valeurtotal = 0;
        if (!empty($total_annuel)) {
            foreach ($values as $value) {
                $valeurtotal += $total_annuel->{$value};
            }
        }
        $valeurtotal = number_format($valeurtotal ?? 0, 2, ',', ' ');

        return view('/commune/chez_tp', [
            'IDRegisseur' => $request->regisseurs,
            'typeRegisseur' => 'chez_tp',
            'values' => $values,
            'months' => $months,
            'annee' => $request->annee,
            'commune_Name' => $nom,
            'reste' => $repriseAPP['total'] ?? [],
            'resteTP' => $repriseTp,
            'donnes' => $donnes,
            'sommeTP' => $sommeTP,
            'sommeAP' => $sommeAP,
            'total_annuel' => $total_annuel,
            'valeurtotal' => $valeurtotal,
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
    public function store(Request $request, $typeRegisseur,$annee , $IDRegisseur, $nom)
    {


        $totalAnnuel= ['0.5' => 0, '1' => 0, '2' => 0,'7'=>0, '5' => 0, '50' => 0];
        $months = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ];
        $values = ['0.5', '1', '5','7', '2', '50'];

        $reste = ['0.5' => 0, '1' => 0, '2' => 0, '5' => 0, '50' => 0];

        $table = '';
        $model = null;

        if ($typeRegisseur == 'approvisionnement') {
            $table = 'a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s';
            $model = new APPROVISIONNEMENT();
        } elseif ($typeRegisseur == 'versement') {
            $table = 'v_e_r_s_e_m_e_n_t_s';
            $model = new VERSEMENT();
        } elseif ($typeRegisseur == 'chez_tp') {
            $table = 'chez__t_p_s';
            $model = new Chez_TP();
        }
        $com = commune::where('name', $nom)->first();
        if ($table && $model) {
            if ($typeRegisseur == 'chez_tp') {

                $check = DB::table('chez__t_p_s')
                    ->where('commune_id', $com->id)
                    ->where('annee', $annee)
                    ->orderBy('id')
                    ->get();

            } else {
                $check = DB::table($table)
                    ->where('regisseur_id', $IDRegisseur)
                    ->where('annee', $annee)
                    ->orderBy('id')
                    ->get();
            }

            if ($check->count() != 0) {
                foreach ($check as $month) {
                    $sum = 0;
                    foreach ($request[$month->mois] as $coeff => $value) {
                        $sum += doubleval($value) * doubleval($coeff);

                    }
                    $sums[$month->mois] = $sum;

                    $totalAnnuel['0.5'] += $request[$month->mois]['0.5']*0.5;
                    $totalAnnuel['1'] += $request[$month->mois]['1']*1;
                    $totalAnnuel['2'] += $request[$month->mois]['2']*2;
                    $totalAnnuel['7'] += $request[$month->mois]['7']*7;
                    $totalAnnuel['5'] += $request[$month->mois]['5']*5;
                    $totalAnnuel['50'] += $request[$month->mois]['50']*50;

                    $var = $model::find($month->id);
                    $var->update([
                        'Somme' => $sum,
                        '1' => $request[$month->mois]['1'],
                        '2' => $request[$month->mois]['2'],
                        '7' => $request[$month->mois]['7'],
                        '5' => $request[$month->mois]['5'],
                        '50' => $request[$month->mois]['50'],
                    ]);

                    $racho = '0.5';
                    $newValue = $request[$month->mois][$racho];
                    $varId = $var->id;
                    $sql = "UPDATE $table SET `$racho` = ?, `updated_at` = ? WHERE `id` = ?";
                    DB::statement($sql, [$newValue, now(), $varId]);
                }
            } else {
                foreach ($months as $month) {
                    $sum = 0;
                    foreach ($request[$month] as $coeff => $value) {
                        $sum += doubleval($value) * doubleval($coeff);
                    }
                    $sums[$month] = $sum;

                    $totalAnnuel['0.5'] += $request[$month]['0.5']*0.5;
                    $totalAnnuel['1'] += $request[$month]['1']*1;
                    $totalAnnuel['2'] += $request[$month]['2']*2;
                    $totalAnnuel['7'] += $request[$month]['7']*7;
                    $totalAnnuel['5'] += $request[$month]['5']*5;
                    $totalAnnuel['50'] += $request[$month]['50']*50;

                    $var = $model::create([
                        'mois' => $month,
                        'annee' => $annee,
                        'Somme' => $sum,
                        '1' => $request[$month]['1'],
                        '2' => $request[$month]['2'],
                        '5' => $request[$month]['5'],
                        '7' => $request[$month]['7'],
                        '50' => $request[$month]['50'],

                    ]);
                    if ($typeRegisseur == 'chez_tp') {
                        $var->update([
                            'commune_id' => $com->id,
                        ]);

                    }else{
                        $var->update([
                            'regisseur_id' => $IDRegisseur,
                        ]);

                    }

                    $racho = '0.5';
                    $newValue = $request[$month][$racho];
                    $varId = $var->id;
                    $sql = "UPDATE $table SET `$racho` = ?, `updated_at` = ? WHERE `id` = ?";
                    DB::statement($sql, [$newValue, now(), $varId]);
                }
            }
        }

        $totalController = new TotalController();
        $totalController->store($totalAnnuel, $typeRegisseur, $annee, $IDRegisseur,$nom);
        if ($typeRegisseur == 'chez_tp') {
            $commune = commune::where('name', $nom)->first();
            return redirect('/commune/' . $commune->region);
        }else{
            $commune=regisseur::find($IDRegisseur)->commune()->first();
            return redirect('/commune/'.$commune->region);
        }

    }




    /**
     * Display the specified resource.
     */
    public function show(Request $request, $name)
    {



        $selectedYear = $request->input('anneetab1');

        $commune = commune::where('name', $name)->first();
        $regis=$commune->regisseurs()->get();
        return \view('commune.type',['name'=>$commune->name,'selectedYear'=>$selectedYear]);


    }

    public function type(Request $request, $name, $annee)
    {
        $table_total = ['0.5' => 0, '1' => 0, '2' => 0,'7'=>0, '5' => 0, '50' => 0];         $values = ['0.5','1', '5','7', '2', '50'];
        $total_appro = [];        $total_ver = [];
        $table_mois = array_fill_keys([
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
            'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
        ], array_fill_keys($values, 0));
        $table_total_mois = array_fill_keys($values, 0);
        $reste = [];
        switch ($request->type) {
            case 'approvisionnement':
                $table_name = 'a_p_p_r_o_v_i_s_i_o_n_n_e_m_e_n_t_s';
                $typeRegisseur = 'approvisionnement';
                break;
            case 'versement':
                $table_name = 'v_e_r_s_e_m_e_n_t_s';
                $typeRegisseur = 'versement';
                break;
        }
        $commune = commune::where('name', $request->name)->first();
        $regis=$commune->regisseurs()->get();
        $type = $request->type;
        if($type=='reste'){
            //Approvisionnement
            foreach ($regis as $regi) {
                foreach ($values as $value) {
                    $column = "`" . $value . "`";
                    $total_appro[$regi->id][$value] = DB::table('totals')
                        ->where('regisseur_id', $regi->id)
                        ->where('annee', $annee)
                        ->where('type', 'approvisionnement')
                        ->sum(DB::raw($column));
                }
            }
            foreach ($values as $value) {
                $total_sum = 0;
                foreach ($total_appro as $regi->id => $appro) {
                    if (isset($appro[$value])) {

                        $total_sum += $appro[$value];
                    }
                }
                $total_appro['total'][$value] = $total_sum;
            }
// Versement
            $regis=$commune->regisseurs()->get();
            foreach ($regis as $regi) {
                foreach ($values as $value) {

                    $column = "`" . $value . "`";
                    $total_ver[$regi->id][$value] = DB::table('totals')
                        ->where('regisseur_id', $regi->id)
                        ->where('annee', $annee)
                        ->where('type', 'versement')
                        ->sum(DB::raw($column));
                }
            }
            foreach ($values as $value) {
                $total_sum = 0;
                foreach ($total_ver as $regi->id => $ver) {
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
            $table_total['7'] += $total_appro['total']['7'] - $total_ver['total']['7'];
            $table_total['5'] += $total_appro['total']['5'] - $total_ver['total']['5'];
            $table_total['50'] += $total_appro['total']['50'] - $total_ver['total']['50'];

            return view('commune.totalRecap', [
                'table_total'=>  $table_total,
                'values' => $values,
                'commune_name' => $name,
                'total_appro' => $total_appro,
                'total_ver' => $total_ver,
                'selectedYear' => $annee,
            ]);

        }
        elseif($type=='approvisionnement' || $type=='versement'){
            //RESTE
            foreach ($regis as $regi) {
                foreach ($values as $value) {
                    $column = "`" . $value . "`";
                    $reste[$regi->id][$value] = DB::table('recaps')
                        ->where('regisseur_id', $regi->id)
                        ->where('annee', $annee-1)
                        ->where('type', $type)
                        ->sum(DB::raw($column));
                }
            }

            foreach ($values as $value) {
                $total_sum = 0;
                foreach ($reste as $regi->id => $appro) {
                    if (isset($appro[$value])) {

                        $total_sum += $appro[$value];
                    }
                }
                $reste['total'][$value] = $total_sum;
            }

        // Colonne des mois pour chaque régisseur
            foreach ($regis as $regi) {
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
            }

            // total ligne derniere
            foreach ($regis as $regi) {
                foreach ($values as $value) {
                    $column = "`" . $value . "`";
                    $total_appro[$regi->id][$value] = DB::table('totals')
                        ->where('regisseur_id', $regi->id)
                        ->where('annee', $annee)
                        ->where('type', $type)
                        ->sum(DB::raw($column));
                }
            }

            foreach ($values as $value) {
                $total_sum = 0;
                foreach ($total_appro as $regi->id => $appro) {
                    if (isset($appro[$value])) {

                        $total_sum += $appro[$value];
                    }
                }
                $total_appro['total'][$value] = $total_sum;
            }
        }

        return view('commune.totale', [
            'reste' => $reste,
            'typeRegisseur'=>$type,
            'table_mois' => $table_mois,
            'values' => $values,
            'commune_name' => $name,
            'total_appro' => $total_appro,
            'annee' => $annee,
            'type' => $type,
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
