<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('public.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('public.register');
    }

    /**
     * * Start session
     */

    public function authenticate(Request $request):RedirectResponse{

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with(['error' => 'Las credenciales enviadas no coinciden, vuelva a intentar',])->onlyInput('email');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->password == $request->passwordc){
            $userData = [
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            User::create($userData);
            return back()->with('success', 'Su cuenta ha sido creado con exito');
        }
        return back()->with(['error' => 'Las contraseñas no coinciden,vuelva a intentar',])->onlyInput('password');
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
