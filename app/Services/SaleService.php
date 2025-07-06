<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Installment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SaleService
{
    public function createSale(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Criar a venda
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'customer_id' => $data['customer_id'] ?? null,
                'payment_method_id' => $data['payment_method_id'],
                'total_amount' => $data['total_amount'],
                'installments' => $data['installments'] ?? 1,
                'sale_date' => $data['sale_date'] ?? now()->toDateString(),
                'notes' => $data['notes'] ?? null,
                'status' => 'completed'
            ]);

            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['quantity'] * $item['unit_price']
                    ]);

                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            }

            $this->createInstallments($sale, $data);

            return $sale;
        });
    }

    public function updateSale(Sale $sale, array $data)
    {
        return DB::transaction(function () use ($sale, $data) {
            // Restaurar estoque dos itens antigos
            foreach ($sale->saleItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            // Remover itens e parcelas antigas
            $sale->saleItems()->delete();
            $sale->installmentRecords()->delete();

            // Atualizar dados da venda
            $sale->update([
                'customer_id' => $data['customer_id'] ?? null,
                'payment_method_id' => $data['payment_method_id'],
                'total_amount' => $data['total_amount'],
                'installments' => $data['installments'] ?? 1,
                'sale_date' => $data['sale_date'] ?? $sale->sale_date,
                'notes' => $data['notes'] ?? null,
            ]);

            // Criar novos itens
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['quantity'] * $item['unit_price']
                    ]);

                    // Atualizar estoque
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            }

            // Criar novas parcelas
            $this->createInstallments($sale, $data);

            return $sale;
        });
    }

    private function createInstallments(Sale $sale, array $data)
    {
        $installments = $data['installments'] ?? 1;

        // Verificar se há parcelas personalizadas
        if (isset($data['custom_installments']) && is_array($data['custom_installments'])) {
            // Criar parcelas personalizadas
            foreach ($data['custom_installments'] as $number => $installmentData) {
                Installment::create([
                    'sale_id' => $sale->id,
                    'installment_number' => $number,
                    'amount' => $installmentData['amount'],
                    'due_date' => $installmentData['due_date'],
                    'status' => $installmentData['status'] ?? 'pending'
                ]);
            }
        } else {
            // Criar parcelas automáticas (comportamento padrão)
            $totalAmount = $sale->total_amount;
            $installmentAmount = $totalAmount / $installments;

            for ($i = 1; $i <= $installments; $i++) {
                $dueDate = Carbon::parse($sale->sale_date)->addMonths($i - 1);

                Installment::create([
                    'sale_id' => $sale->id,
                    'installment_number' => $i,
                    'amount' => $installmentAmount,
                    'due_date' => $dueDate->toDateString(),
                    'status' => 'pending'
                ]);
            }
        }
    }
}
