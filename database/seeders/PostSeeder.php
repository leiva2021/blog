<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

use Illuminate\Database\Seeder;
use Database\Seeders\Factory;
use Illuminate\Support\Facades\Storage;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /*Storage::deleteDirectory('posts');
        Storage::makeDirectory('posts');*/

        // * php artisan db:seed --class=DatabaseSeeder
        // * mkdir -p public/storage/posts
        // * php artisan db:seed --class=DatabaseSeeder --force


        $posts = Post::factory(10)->create();
    }
}
