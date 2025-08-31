<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_shop_list_show()
    {
        $restaurants = Restaurant::factory()->count(3)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        foreach ($restaurants as $restaurant) {
            $response->assertSee($restaurant->name);
        }
    }

    public function test_search_area()
    {
        $areaTokyo = Area::factory()->create(['area' => '東京都']);
        $areaOsaka = Area::factory()->create(['area' => '大阪府']);
        $genre = Genre::factory()->create();

        $shopTokyo = Restaurant::factory()->create([
            'name' => '東京の店',
            'area_id' => $areaTokyo->id,
            'genre_id' => $genre->id,
        ]);

        $shopOsaka = Restaurant::factory()->create([
            'name' => '大阪の店',
            'area_id' => $areaOsaka->id,
            'genre_id' => $genre->id,
        ]);

        $response = $this->get('/search?area_id=' . $areaTokyo->id);
        $response->assertStatus(200);
        $response->assertSee('東京の店');
        $response->assertDontSee('大阪の店');
    }

    public function test_search_genre()
    {
        $area = Area::factory()->create();
        $sushi = Genre::factory()->create(['genre' => '寿司']);
        $ramen = Genre::factory()->create(['genre' => 'ラーメン']);

        $shopSushi = Restaurant::factory()->create([
            'name' => '銀座寿司',
            'area_id' => $area->id,
            'genre_id' => $sushi->id,
        ]);

        $shopRamen = Restaurant::factory()->create([
            'name' => '新宿ラーメン',
            'area_id' => $area->id,
            'genre_id' => $ramen->id,
        ]);

        $response = $this->get('/search?genre_id=' . $sushi->id);

        $response->assertStatus(200);
        $response->assertSee('銀座寿司');
        $response->assertDontSee('新宿ラーメン');
    }

    public function test_search_name()
    {
        $area = Area::factory()->create();
        $genre = Genre::factory()->create();

        $shop1 = Restaurant::factory()->create([
            'name' => '銀座寿司',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
        ]);

        $shop2 = Restaurant::factory()->create([
            'name' => '新宿ラーメン',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
        ]);

        $response = $this->get('/search?keyword=寿司');

        $response->assertStatus(200);
        $response->assertSee('銀座寿司');
        $response->assertDontSee('新宿ラーメン');
    }

    public function test_favorite_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'users');
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee($restaurant->name);

        $response = $this->post(route('favorite.toggle'), [
            'restaurant_id' => $restaurant->id,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('favorites', [
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);
    }

    public function test_favorite_form_remove()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'users');
        $restaurant = Restaurant::factory()->create();
        $user->favorites()->attach($restaurant->id);
        $this->assertDatabaseHas('favorites', [
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);
        $response = $this->post(route('favorite.toggle'), [
            'restaurant_id' => $restaurant->id,
        ]);
        $response->assertRedirect();
        $this->assertDatabaseMissing('favorites', [
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);
    }
}
