<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name' => 'Sản phẩm ' . ($i + 1),
                'price' => rand(10000, 1000000),
                'description' => 'Mô tả cho sản phẩm ' . ($i + 1),
                'image' => 'https://fakeimg.pl/440x320/282828/eae0d0/?retina=1',
                'stock_quantity' => rand(1, 100),
                'is_active' => 1,
            ]);
        }
    }
}