<?php

namespace App\Http\Controllers;

use App\Models\commune;
use App\Models\recap;
use App\Models\RecapTp;
use App\Models\total;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store($typeRegisseur, $annee, $IDRegisseur, $nomcom)
    {
        $reste = ['0.5' => 0, '1' => 0, '2' => 0, '5' => 0, '50' => 0];
        $keysToFetch = ['0.5', 1, 2, 5, 50];
        $check = DB::table('recaps')
            ->where('regisseur_id', $IDRegisseur)
            ->where('annee', $annee)
            ->where('type', $typeRegisseur)
            ->orderBy('id')
            ->get();
        if ($typeRegisseur == 'approvisionnement' || $typeRegisseur == 'versement') {

        $reprise = DB::table('totals')
            ->where('regisseur_id', $IDRegisseur)
            ->where('annee', $annee )
            ->whereIn('type', ['approvisionnement', 'versement'])
            ->orderBy('type')
            ->get();

        if ($reprise->count() > 1) {
            $reste['0.5'] += ($reprise[0]->{'0.5'} ?? 0) - ($reprise[1]->{'0.5'} ?? 0);
            $reste['1'] += ($reprise[0]->{'1'} ?? 0) - ($reprise[1]->{'1'} ?? 0);
            $reste['2'] += ($reprise[0]->{'2'} ?? 0) - ($reprise[1]->{'2'} ?? 0);
            $reste['5'] += ($reprise[0]->{'5'} ?? 0) - ($reprise[1]->{'5'} ?? 0);
            $reste['50'] += ($reprise[0]->{'50'} ?? 0) - ($reprise[1]->{'50'} ?? 0);
        }

        }

        elseif ($typeRegisseur == 'chez_tp') {
            $com = commune::where('name', $nomcom)->first();

            $totalTP=DB::table('total_tps')
                ->where('commune_id', $com->id)
                ->where('annee', $annee)
                ->where('type','chez_tp')
                ->orderBy('id')
                ->get();

          //  $totalAPP
            $regis = $com->regisseurs()->get();
            foreach ($regis as $regi) {
                foreach ($keysToFetch as $value) {
                    $column = $value;

                    $totalAPP[$regi->id][$value] = DB::table('recaps')
                        ->where('regisseur_id', $regi->id)
                        ->where('annee', $annee-1 )
                        ->where('type', 'approvisionnement')
                        ->sum(DB::raw("`$column`"));

                }
            }

            foreach ($keysToFetch as $value) {
                $total_sum = 0;
                foreach ($totalAPP as $regi->id => $appro) {
                    if (isset($appro[$value])) {

                        $total_sum += $appro[$value];
                    }
                }
                $totalAPP['total'][$value] = $total_sum;
            }

            $values = ['0.5', '1', '5', '2', '50'];
            foreach ($values as $value) {
                $reste[$value] += ($totalTP->first()->{$value} ?? 0)-($totalAPP['total'][$value] ?? 0);
            }

        }
        if ($check->count()==0) {

            $var = RecapTp::create([
                'type' => $typeRegisseur,
                'annee' => $annee,
                'commune_id' => $com->id,
            ]);

            foreach ($keysToFetch as $key) {
                $newValue = $reste[$key];
                $varId = $var->id;
                $sql = "UPDATE `recap_tps` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                DB::statement($sql, [$newValue, now(), $varId]);
            }
        } else {
            foreach ($check as $item) {
                $var = RecapTp::find($item->id);
                $var->update([
                    'type' => $typeRegisseur,
                    'annee' => $annee,
                    'commune_id' => $com->id,
                ]);

                foreach ($keysToFetch as $key) {
                    $newValue = $reste[$key];
                    $varId = $var->id;
                    $sql = "UPDATE `recap_tps` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                    DB::statement($sql, [$newValue, now(), $varId]);
                }

            }
        }

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
