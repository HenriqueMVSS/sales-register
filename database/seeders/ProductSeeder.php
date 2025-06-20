<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Smartphone Samsung Galaxy A54',
                'description' => 'Smartphone Samsung Galaxy A54 128GB 5G',
                'price' => 1299.99,
                'stock' => 50,
                'active' => true
            ],
            [
                'name' => 'Notebook Dell Inspiron 15',
                'description' => 'Notebook Dell Inspiron 15 3000 Intel Core i5 8GB 256GB SSD',
                'price' => 2799.99,
                'stock' => 20,
                'active' => true
            ],
            [
                'name' => 'Smart TV LG 43"',
                'description' => 'Smart TV LED 43" LG ThinQ AI Full HD HDR',
                'price' => 1599.99,
                'stock' => 15,
                'active' => true
            ],
            [
                'name' => 'Fone de Ouvido JBL',
                'description' => 'Fone de Ouvido JBL Tune 510BT Bluetooth',
                'price' => 199.99,
                'stock' => 100,
                'active' => true
            ],
            [
                'name' => 'Mouse Gamer',
                'description' => 'Mouse Gamer Óptico USB 2400 DPI',
                'price' => 89.99,
                'stock' => 75,
                'active' => true
            ],
            [
                'name' => 'Teclado Mecânico',
                'description' => 'Teclado Mecânico Gamer RGB ABNT2',
                'price' => 299.99,
                'stock' => 30,
                'active' => true
            ],
            [
                'name' => 'Monitor 24"',
                'description' => 'Monitor LED 24" Full HD IPS',
                'price' => 699.99,
                'stock' => 25,
                'active' => true
            ],
            [
                'name' => 'Cabo USB-C',
                'description' => 'Cabo USB-C para USB-A 1 metro',
                'price' => 29.99,
                'stock' => 200,
                'active' => true
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
