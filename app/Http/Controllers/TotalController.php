<?php

namespace App\Http\Controllers;

use App\Models\APPROVISIONNEMENT;
use App\Models\regisseur;
use App\Models\total;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalController extends Controller
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
    public function store(Request $request, $typeRegisseur,$annee, $IDRegisseur)
    {
        $check=DB::table('totals')
            ->where('regisseur_id',$IDRegisseur)
            ->where('annee',$annee)
            ->orderBy('id')
            ->get();

        if ($check->count()==0){
                $var= total::create([
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
                    $sum=0;
                    foreach ($months as $month) {
                        $sum += $request[$month][$key];
                    }
                    $totalMensuelle=$sum*$key;
                    //dd($totalMensuelle);
                        $newValue =  $totalMensuelle;
                        $varId = $var->id;
                    $sql = "UPDATE `totals` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                        DB::statement($sql, [$newValue, now(), $varId]);

        }
        }
        else {

            foreach ($check as $var){
                //dd($var->id);
            $var = total::find($var->id);
            $var->update([
                'type' => $typeRegisseur,
                'annee' => $annee,
                'regisseur_id' => $IDRegisseur,
            ]);
            }
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
                //dd($totalMensuelle);
                $newValue = $totalMensuelle;
                $varId = $var->id;
                $sql = "UPDATE `totals` SET `$key` = ?, `updated_at` = ? WHERE `id` = ?";
                DB::statement($sql, [$newValue, now(), $varId]);
            }
        }
        $commune=regisseur::find($IDRegisseur)->cu()->first();
        return redirect('/Cu/'.$commune->cu_name);
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
