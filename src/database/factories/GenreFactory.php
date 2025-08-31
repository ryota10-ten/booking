<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Genre::class;

    public function definition()
    {
        return [
            'genre' => $this->faker->word(),
        ];
    }
}
