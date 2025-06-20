<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Dinheiro',
                'description' => 'Pagamento à vista em dinheiro',
                'allows_installments' => false,
                'max_installments' => 1,
                'active' => true
            ],
            [
                'name' => 'PIX',
                'description' => 'Pagamento via PIX',
                'allows_installments' => false,
                'max_installments' => 1,
                'active' => true
            ],
            [
                'name' => 'Cartão de Débito',
                'description' => 'Pagamento com cartão de débito',
                'allows_installments' => false,
                'max_installments' => 1,
                'active' => true
            ],
            [
                'name' => 'Cartão de Crédito',
                'description' => 'Pagamento com cartão de crédito',
                'allows_installments' => true,
                'max_installments' => 12,
                'active' => true
            ],
            [
                'name' => 'Crediário',
                'description' => 'Pagamento parcelado na loja',
                'allows_installments' => true,
                'max_installments' => 24,
                'active' => true
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
