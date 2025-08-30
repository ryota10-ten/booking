<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Manager;
use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ManagerShopAddTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_shop_add()
    {
        Storage::fake('public');
        $area = Area::factory()->create();
        $genre = Genre::factory()->create();
        $manager = Manager::factory()->create();
        $this->actingAs($manager, 'managers');
        $formData = [
            'manager_id' => $manager->id,
            'name' => 'テスト店舗',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'detail' => 'テスト店舗の詳細情報',
            'image' => UploadedFile::fake()->image('shop.jpg'),
        ];
        $response = $this->post(route('shop.store'), $formData);
        $response->assertRedirect();
        $this->assertDatabaseHas('restaurants', [
            'name' => 'テスト店舗',
            'detail' => 'テスト店舗の詳細情報',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'manager_id' => $manager->id,
        ]);
        $restaurant = Restaurant::first();
        Storage::disk('public')->assertExists($restaurant->image);
    }

    public function test_manager_can_edit_shop_info()
    {
        Storage::fake('public');
        $manager = Manager::factory()->create();
        $area = Area::factory()->create();
        $genre = Genre::factory()->create();

        $restaurant = Restaurant::factory()->create([
            'manager_id' => $manager->id,
            'name' => '旧店舗名',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'detail' => '旧店舗概要',
            'img_url' => 'shops/old_image.jpg',
        ]);
        $newData = [
            'name' => '新店舗名',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'detail' => '新しい店舗概要',
            'image' => UploadedFile::fake()->image('new_image.jpg'),
        ];

        $response = $this->actingAs($manager, 'managers')
            ->post(route('shop.update', ['id' => $restaurant->id]), $newData);
        $response->assertRedirect(route('shop_all_show'));
        $updatedRestaurant = Restaurant::find($restaurant->id);
        $this->assertDatabaseHas('restaurants', [
            'id' => $updatedRestaurant->id,
            'name' => '新店舗名',
            'detail' => '新しい店舗概要',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
        ]);
        Storage::disk('public')->assertExists($updatedRestaurant->img_url);
    }
}
