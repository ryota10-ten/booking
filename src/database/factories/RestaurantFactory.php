<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Manager;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Restaurant::class;

    public function definition()
    {
        return [
            'name'       => $this->faker->company,
            'detail'     => $this->faker->sentence(10),
            'genre_id'   => Genre::factory(),
            'area_id'    => Area::factory(),
            'manager_id' => Manager::factory(),
            'img_url'    => $this->faker->imageUrl(),
        ];
    }
}
