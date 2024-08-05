<?php

namespace App\Http\Controllers;

use App\Models\commune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecapTPController extends Controller
{
    public function resteTP($annee,$commune_Name)
    {

        $values = ['0.5', 1, 2, 7, 5, 50];
        $commune = commune::where('name', $commune_Name)->first();
        $reste=array_fill_keys($values, 0);
        $totalTP=DB::table('total_tps')
            ->where('commune_id', $commune->id)
            ->where('annee', $annee)
            ->where('type','chez_tp')
            ->orderBy('id')
            ->get();

        $regis=$commune->regisseurs()->get();
        foreach ($regis as $regi) {
            foreach ($values as $value) {

                $column = "`" . $value . "`";
                $totalAPP[$regi->id][$value] = DB::table('totals')
                    ->where('regisseur_id', $regi->id)
                    ->where('annee', $annee)
                    ->where('type', 'approvisionnement')
                    ->sum(DB::raw($column));
            }
        }
        foreach ($values as $value) {
        $total_sum = 0;
        foreach ($totalAPP as $regi->id => $ver) {
            if (isset($ver[$value])) {

                $total_sum += $ver[$value];
            }
        }
            $totalAPP['total'][$value] = $total_sum;
    }


        $resteTP=DB::table('recap_tps')
            ->where('commune_id', $commune->id)
            ->where('annee', $annee)
            ->where('type','chez_tp')
            ->get();



        $sumTP=0;
        $sumAPP=0;
        $sumrest=0;

        foreach ($values as $value) {
            $sumAPP += $totalAPP['total'][$value] ?? 0;
            $sumTP+= $totalTP->first()->{$value} ?? 0;
            $sumrest+=$resteTP->first()->{$value} ?? 0;

        }


        return view('commune.TpReste',[

                'name'=>$commune_Name,
                'annee'=>$annee,
                'resteTP'=>$resteTP[0],
                'sumrest'=>$sumrest,
                'sumTP'=>$sumTP,
                'chezTp'=>$totalTP,
                'sumREG'=>$sumAPP,
                'chezREG'=>$totalAPP['total'],
                'values'=>$values,
            ]
        );
    }
}
