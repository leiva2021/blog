<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboards.post');
    }

    /**
     * FetchAll post to send by JSON
     */

    public function getFetchAllPosts()
    {
        $posts = Post::all();
        $output = '';
        if ($posts->count() > 0) {
            $output .= '<table id="datatablesSimple" class="table table-hover border">
            <thead>
                <tr>
                    <th><center>ID</center></th>
                    <th><center>Titulo</center></th>
                    <th><center>Slug</center></th>
                    <th><center>Contenido</center></th>
                    <th><center>Imagen</center></th>
                    <th><center>Acciones</center></th>
                </tr>
            </thead>
            <tbody>';
            foreach ($posts as $post) {
                $output .= '<tr>
                <td><center>' . $post->id . '</center></td>
                <td><center>' . $post->title . '</center></td> 
                <td><center>' . $post->slug . '</center></td>
                <td><center><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal' . $post->id . '">Ver mas</button></center></td>
                <td><img src="storage/' . $post->url . '" width="60" class="img-thumbnail"></td>
                <td>
                    <center>
                        <a href="' . route("post.edit", ["id" => $post->id]) . '"  class="btn btn-warning"><i class="fas fa-edit"></i></a>
                        <a href="#" id="' . $post->id . '" class="btn btn-danger deleteIcon"><i class="fas fa-trash-alt"></i></a>
                    </center>
                </td>
            </tr>

                <!-- Modal -->

                    <div class="modal fade" id="exampleModal' . $post->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>"' . $post->content . '"</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                            </div>
                        </div>
                    </div>
            ';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No hay registros en la base de datos!</h1>';
        }
        // ? end of $output

        // * ::::::::::::: FALTA IMPLEMENTAR EL METODO ELIMINAR POST
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* $categories = Category::pluck('name','id'); */ // * Laravel collective
        $categories = Category::all();
        return view('dashboards.form.addpostform')->with(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*if($request->user_id == auth()->user()->id){
            return true;
        }else {
            echo 'Accion no valida';
        }*/

        // $url = Storage::put('posts',$request->file('file'));
        $file = $request->file('file');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/posts', $fileName);

        $postData = [
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'url' => 'posts/' . $fileName,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id
        ];

        Post::create($postData);
        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $post = Post::findOrFail($request->id);
        $categories = Category::all();

        return view('dashboards.form.editpostform')->with([
            'categories' => $categories,
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // * Validar al usuario
        $fileName = '';
        $post = Post::findOrFail($request->postid);

        if ($request->hasFile('file')) {
            
            $file = $request->file('file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/posts', $fileName);
            if ($post->url) {
                Storage::delete('public/' . $post->url);
            }
            // * ===================Con imagen======================
            $postData = [
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'url' =>  'posts/' . $fileName,
            'category_id' => $request->category_id
            ];

            $post->update($postData);

        } else {
            
            $OldfileName = $request->temp_image;
            // * ==================Sin Imagen=======================
            $postData = [
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'url' =>  $OldfileName,
                'category_id' => $request->category_id
            ];

            $post->update($postData);
        }

        return response()->json([
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
