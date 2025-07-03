<?php

namespace Database\Factories;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $is_accepted = random_int(0, 1);
        return [
            'merchant_id' => 1,
            'category_id' => 1,
            'product_name' => $this->faker->name(),
            'product_description' => $this->faker->text(),
            'price' => 20000,
            'heavy' => 10,
            'stok' => 10,
            'expired_at' => $this->faker->date(),
            'is_request' => 1,
            'user_id' => 2,
            'image' => 'example.png',
            'is_accepted' => $is_accepted,
            'alasan_ditolak' => $is_accepted ? '' : $this->faker->text(),
            'in_gallery' => 0,
            'is_deleted' => 0,
        ];
    }
}
