<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraph(3,true),
            'url' => 'posts/'. $this->faker->image('public/storage/posts',640,480,null,false),
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' =>  User::inRandomOrder()->first()->id,
        ];
    }
}
