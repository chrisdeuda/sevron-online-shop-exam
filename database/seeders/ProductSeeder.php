<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $json = File::get(resource_path('data/products.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            Product::create([
                'id' => Str::uuid(),
                'name' => $item['title'],
                'description' => $item['description'],
                'price' => $item['price'],
                'photo' => $item['image'],
            ]);
        }
    }
}
