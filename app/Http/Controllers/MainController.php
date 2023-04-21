<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    private $categories;

    public function __construct()
    {
        $this->categories = Category::all();
    }

    public function index()
    {
        return view('public.index')->with(['categories' => $this->categories]);
    }

    public function about()
    {
        return view('public.about')->with(['categories' => $this->categories]);
    }

    /**
     * * Filter posts by category ID
     */

    public function filterpostsbycategory(Request $request)
    {
        $posts = Post::where('category_id', $request->id)->get();
        return view('public.showpostsbycategory')->with([
            'categories' => $this->categories,
            'posts' => $posts
        ]);
    }

    public function showpost(Request $request)
    {
        // * Validar consultas
        $post = Post::findOrFail($request->id);

        $comments = DB::table('comments')
            ->join(
                'users',
                'comments.user_id',
                '=',
                'users.id'
            )
            ->select('comments.*', 'users.name')
            ->where('comments.post_id', '=', $post->id)
            ->get();

        return view('public.showpost')->with([
            'categories' => $this->categories,
            'post' => $post,
            'comments' => $comments
        ]);
    }
}
