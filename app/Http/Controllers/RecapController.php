<?php

namespace App\Http\Controllers;

use App\Models\recap;
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
    public function store($typeRegisseur, $annee, $IDRegisseur)
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

            $totalTP=DB::table('totals')
                ->where('regisseur_id', $IDRegisseur)
                ->where('annee', $annee)
                ->where('type','chez_tp')
                ->orderBy('id')
                ->get();

            $totalAPP=DB::table('totals')
                ->where('regisseur_id', $IDRegisseur)
                ->where('annee', $annee)
                ->where('type','approvisionnement')
                ->orderBy('id')
                ->get();


            $values = ['0.5', '1', '2', '5', '50'];
            foreach ($values as $value) {
                $reste[$value] += ($totalTP->first()->{$value} ?? 0)-($totalAPP->first()->{$value} ?? 0);
            }

        }
        if ($check->count()==0) {

            $var = recap::create([
                'type' => $typeRegisseur,
                'annee' => $annee,
                'regisseur_id' => $IDRegisseur,
            ]);

            foreach ($keysToFetch as $key) {
                $newValue = $reste[$key];
                $varId = $var->id;
                $sql = "UPDATE `recaps` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                DB::statement($sql, [$newValue, now(), $varId]);
            }
        } else {
            foreach ($check as $item) {
                $var = recap::find($item->id);
                $var->update([
                    'type' => $typeRegisseur,
                    'annee' => $annee,
                    'regisseur_id' => $IDRegisseur,
                ]);

                foreach ($keysToFetch as $key) {
                    $newValue = $reste[$key];
                    $varId = $var->id;
                    $sql = "UPDATE `recaps` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
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
