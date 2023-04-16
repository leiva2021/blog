<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboards.adminuser');
    }

    /**
     *  Method to send all users for JSON
     */

    public function fetchAllUsers()
    {
        $users = User::all();
        $output = '';
        if ($users->count() > 0) {
            $output .= '<table id="datatablesSimple" class="table table-hover border">
            <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center>Nombre</center></th>
                    <th><center>Email</center></th>
                    <th><center>Contraseña</center></th>
                    <th><center>Acciones</center></th>
                </tr>
            </thead>
            <tbody>';
            foreach ($users as $user) {
                $output .= '<tr>
                <td><center>' . $user->id . '</center></td>
                <td><center>' . $user->name . '</center></td> 
                <td><center>' . $user->email . '</center></td>
                <td><center>' . $user->password . '</center></td>
                <td>
                    <center>
                        <a href="#" id="' . $user->id . '" class="btn btn-warning editIcon" data-bs-toggle="modal" data-bs-target="#EditUserModal">Editar</a>
                        <a href="#" id="' . $user->id . '" class="btn btn-danger deleteIcon">Eliminar</a>
                    </center>
                </td>
            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No hay registros en la base de datos!</h1>';
        }
        // ? end of $output
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

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        User::create($userData);
        return response()->json([
            'status' => 200
        ]);
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
    public function edit(Request $request)
    {
        // * Validar 
        $id = $request->id;
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // * Validar aqui tambien
        $user = User::findOrFail($request->id);

        $userData = [
            'name' => $request->name,
            'email' => $request->email
        ];

        $user->update($userData);

        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // validar aca
        $id = $request->id;
        User::destroy($id);

        return response()->json([
            'status' => 200
        ]);
    }
}
