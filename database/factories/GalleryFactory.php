<?php

namespace Database\Factories;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_accepted = random_int(0, 1);
        $merchant = Merchant::inRandomOrder()->first();
        return [
            'merchant_id' => $merchant->merchant_id,
            'category_id' => $this->faker->randomElement([1, 2, 3, 7, 8, 9, 14]),
            'product_name' => $this->faker->name(),
            'product_description' => $this->faker->text(),
            'price' => 20000,
            'heavy' => 10,
            'stok' => 10,
            'expired_at' => $this->faker->date(),
            'is_request' => 1,
            'user_id' => $merchant->user_id,
            'image' => 'example.png',
            'is_accepted' => $is_accepted,
            'alasan_ditolak' => $is_accepted ? '' : $this->faker->text(),
            'in_gallery' => 0,
            'is_deleted' => 0,
        ];
    }
}
