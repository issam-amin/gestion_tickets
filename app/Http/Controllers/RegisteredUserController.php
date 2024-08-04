<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
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
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the request
        $attributes= request()->validate([

            'name' => ['required'],
            'email' => ['required', 'email', 'max:255'],
            'email_verified_at' => 'nullable|date',
            'password' => ['required', password::min(8), 'confirmed']
        ]);

        //store the user / insert the user into the database
        $user=User::create($attributes); // methode 2 in block note

        //log the user in
        auth()->login($user);

        //redirect
        return redirect('/')->with('success', 'Your account has been created.');
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
