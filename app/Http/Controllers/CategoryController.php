<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('dashboards.category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    // * Enviar la lista de categorias por JSON
    public function getAllCategories()
    {

        $categories = Category::all();
        $output = '';
        if ($categories->count() > 0) {
            $output .= '<table id="datatablesSimple" class="table table-hover border">
            <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center>Nombre</center></th>
                    <th><center>Slug</center></th>
                    <th><center>Acciones</center></th>
                </tr>
            </thead>
            <tbody>';
            foreach ($categories as $category) {
                $output .= '<tr>
                <td><center>' . $category->id . '</center></td>
                <td><center>' . $category->name . '</center></td> 
                <td><center>' . $category->slug . '</center></td>
                <td>
                    <center>
                        <a href="#" id="' . $category->id . '" class="btn btn-warning editIcon" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Editar</a>
                        <a href="#" id="' . $category->id . '" class="btn btn-danger deleteIcon">Eliminar</a>
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categoryData = [
            'name' => $request->name,
            'slug' => $request->slug
        ];

        Category::create($categoryData);

        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $categoryData = [
            'name' => $request->name,
            'slug' => $request->slug
        ];

        $category->update($categoryData);
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
        Category::destroy($id);

        return response()->json([
            'status' => 200
        ]);
    }
}
