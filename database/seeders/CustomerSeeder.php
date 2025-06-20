<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'João Silva Santos',
                'email' => 'joao.silva@email.com',
                'phone' => '(11) 99999-1234',
                'document' => '123.456.789-00',
                'address' => 'Rua das Flores, 123, Centro, São Paulo - SP'
            ],
            [
                'name' => 'Maria Oliveira Lima',
                'email' => 'maria.oliveira@email.com',
                'phone' => '(11) 98888-5678',
                'document' => '987.654.321-00',
                'address' => 'Av. Paulista, 456, Bela Vista, São Paulo - SP'
            ],
            [
                'name' => 'Carlos Eduardo Pereira',
                'email' => 'carlos.pereira@empresa.com',
                'phone' => '(11) 97777-9012',
                'document' => '12.345.678/0001-90',
                'address' => 'Rua Comercial, 789, Vila Madalena, São Paulo - SP'
            ],
            [
                'name' => 'Ana Paula Costa',
                'email' => 'ana.costa@email.com',
                'phone' => '(11) 96666-3456',
                'document' => '456.789.123-00',
                'address' => 'Rua dos Jardins, 321, Jardins, São Paulo - SP'
            ],
            [
                'name' => 'Pedro Henrique Alves',
                'email' => 'pedro.alves@email.com',
                'phone' => '(11) 95555-7890',
                'document' => '789.123.456-00',
                'address' => 'Av. Rebouças, 654, Pinheiros, São Paulo - SP'
            ],
            [
                'name' => 'Fernanda Rodrigues',
                'email' => 'fernanda.rodrigues@email.com',
                'phone' => '(11) 94444-2468',
                'document' => '321.654.987-00',
                'address' => 'Rua Augusta, 987, Consolação, São Paulo - SP'
            ],
            [
                'name' => 'Tech Solutions Ltda',
                'email' => 'contato@techsolutions.com.br',
                'phone' => '(11) 3333-1111',
                'document' => '98.765.432/0001-10',
                'address' => 'Av. Faria Lima, 1500, Itaim Bibi, São Paulo - SP'
            ],
            [
                'name' => 'Roberto Carlos Medeiros',
                'email' => 'roberto.medeiros@email.com',
                'phone' => '(11) 92222-8888',
                'document' => '654.321.987-00',
                'address' => 'Rua Teodoro Sampaio, 258, Pinheiros, São Paulo - SP'
            ],
            [
                'name' => 'Luciana Fernandes',
                'email' => 'luciana.fernandes@email.com',
                'phone' => '(11) 91111-4444',
                'document' => '147.258.369-00',
                'address' => 'Rua Oscar Freire, 741, Jardins, São Paulo - SP'
            ],
            [
                'name' => 'Comercial ABC Ltda',
                'email' => 'vendas@comercialabc.com.br',
                'phone' => '(11) 3000-2000',
                'document' => '11.222.333/0001-44',
                'address' => 'Rua do Comércio, 852, República, São Paulo - SP'
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
