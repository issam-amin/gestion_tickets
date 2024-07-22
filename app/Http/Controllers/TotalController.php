<?php

namespace App\Http\Controllers;

use App\Models\APPROVISIONNEMENT;
use App\Models\CU;
use App\Models\regisseur;
use App\Models\total;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
   {
       $annees = [];
       $typeRegisseur = ['approvisionnement', 'versement' ,'chez_tp'];
       for ($i=2023;$i<Carbon::now()->year+1;$i++){
           $annees[]=$i;
       }

       return view('TotalRecap/choix',
           [
               'typeRegisseur' => $typeRegisseur,
               'annees' => $annees
           ]);
   }
    public function display(Request $request)
    {

        $values = ['0.5', '1', '2', '5', '50'];
        $table_mois=[
            'janvier'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'février'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'mars'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'avril'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'mai'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'juin'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'juillet'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'août'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'septembre'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'octobre'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'novembre'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
            'décembre'=>array('0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0),
        ];
        $table_total_mois=[ '0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0];
        $table_total=[ '0.5'=>0,'1'=>0,'2'=>0,'5'=>0,'50'=>0];
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
        $regisseurs = [];
        $cus = CU::select('id')->get();
        foreach ($cus as $cu)
        {

            $regisseurs=$cu->regisseur()->get();

            foreach ($regisseurs as $regi){

                $table=DB::table($table_name)
                    ->where('regisseur_id',$regi->id)
                    ->where('annee',$annee)
                    ->orderBy('id')
                    ->get();
               foreach ($table as $mois){
                $table_mois[$mois->mois] = [
                    '0.5' => $table_mois[$mois->mois]['0.5'] + $mois->{'0.5'},
                    '1' => $table_mois[$mois->mois]['1'] + $mois->{'1'},
                    '2' => $table_mois[$mois->mois]['2'] + $mois->{'2'},
                    '5' => $table_mois[$mois->mois]['5'] + $mois->{'5'},
                    '50' => $table_mois[$mois->mois]['50'] + $mois->{'50'}
                ];
                }
                $tableT[$regi->id]=DB::table('totals')
                    ->where('regisseur_id',$regi->id)
                    ->where('type',$typeRegisseur)
                    ->where('annee',$annee)
                    ->orderBy('id')
                    ->get();

                $tableTotal=DB::table('totals')
                    ->where('regisseur_id',$regi->id)
                    ->where('annee',$annee-1)
                    ->orderBy('type')
                    ->get();
                if($tableTotal->count()==2)
                {
                    $table_total['0.5'] += $tableTotal[0]->{'0.5'} - $tableTotal[1]->{'0.5'};
                    $table_total['1'] += $tableTotal[0]->{'1'} - $tableTotal[1]->{'1'};
                    $table_total['2'] += $tableTotal[0]->{'2'} - $tableTotal[1]->{'2'};
                    $table_total['5'] += $tableTotal[0]->{'5'} - $tableTotal[1]->{'5'};
                    $table_total['50'] += $tableTotal[0]->{'50'} - $tableTotal[1]->{'50'};
                }


            }

        }
       // dd($table_total);
        foreach ($tableT as $item){
           foreach ($item as $value){
               $table_total_mois['0.5'] += $value->{'0.5'};
               $table_total_mois['1'] += $value->{'1'};
               $table_total_mois['2'] += $value->{'2'};
               $table_total_mois['5'] += $value->{'5'};
               $table_total_mois['50'] += $value->{'50'};
           }

        }

        return view('TotalRecap.RecapeTotal',
            [
                'table_total' => $table_total,
                'table_total_mois'=>$table_total_mois,
                'values' => $values,
                'typeRegisseur'=> $typeRegisseur,
                'table_mois'=> $table_mois
            ]);

    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $typeRegisseur, $annee, $IDRegisseur)
    {
        $check = DB::table('totals')
            ->where('regisseur_id', $IDRegisseur)
            ->where('annee', $annee)
            ->where('type', $typeRegisseur)
            ->orderBy('id')
            ->get();

        if ($check->count() == 0) {
            $var = total::create([
                'type' => $typeRegisseur,
                'annee' => $annee,
                'regisseur_id' => $IDRegisseur,
            ]);

            $months = [
                'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
                'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
            ];

            $keysToFetch = ['0.5', 1, 2, 5, 50];
            foreach ($keysToFetch as $key) {
                $sum = 0;
                foreach ($months as $month) {
                    $sum += $request[$month][$key];
                }
                $totalMensuelle = $sum * $key;
                $newValue = $totalMensuelle;
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

                $months = [
                    'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
                    'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
                ];

                $keysToFetch = ['0.5', 1, 2, 5, 50];
                foreach ($keysToFetch as $key) {
                    $sum = 0;
                    foreach ($months as $month) {
                        $sum += $request[$month][$key];
                    }
                    $totalMensuelle = $sum * $key;
                    $newValue = $totalMensuelle;
                    $varId = $var->id;
                    $sql = "UPDATE `totals` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                    DB::statement($sql, [$newValue, now(), $varId]);
                }
            }
        }

        $commune = regisseur::find($IDRegisseur)->cu()->first();
        return redirect('/Cu/' . $commune->cu_name);
    }


    /**
     * Display the specified resource.
     */
    public function show( $id,  $annee)
    {
       //dd($id, $annee);
        $regisseur=regisseur::find($id);

       // dd($regisseur->name);
        $values = ['0.5', '1', '2', '5', '50'];
        $QUE = DB::table('totals')
            ->where('regisseur_id', $id)
            ->where('annee', $annee)
            ->orderBy('id')
            ->get();
        //dd($QUE);
        return view('/cu/Recape', [
            'name' => $regisseur->name,
            'total' => $QUE,
            'IDRegisseur' => $id,
            'values' => $values,
            'annee' => $annee,
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
