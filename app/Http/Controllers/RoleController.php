<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboards.roles');
    }

    /**
     * FetchAll roles
     */

    public function fetchAllRoles()
    {
        $roles = Role::all();
        $output = '';
        if ($roles->count() > 0) {
            $output .= '<table id="datatablesSimple" class="table table-hover border">
            <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center>Nombre</center></th>
                    <th><center>Acciones</center></th>
                </tr>
            </thead>
            <tbody>';
            foreach ($roles as $rol) {
                $output .= '<tr>
                <td><center>' . $rol->id . '</center></td>
                <td><center>' . $rol->name . '</center></td> 
                <td>
                    <center>
                        <a href="#" id="' . $rol->id . '" class="btn btn-warning editIcon" data-bs-toggle="modal" data-bs-target="#EditRolModal">Editar</a>
                        <a href="#" id="' . $rol->id . '" class="btn btn-danger deleteIcon">Eliminar</a>
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
        $roleData = ['name' => $request->name];
        Role::create($roleData);
        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
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
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // * Validar aqui tambien
        $role = Role::findOrFail($request->id);
        $roleData = ['name' => $request->name];
        $role->update($roleData);

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
        Role::destroy($id);

        return response()->json([
            'status' => 200
        ]);
    }
}
