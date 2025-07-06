<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'sale_date' => 'required|date',
            'installments' => 'required|integer|min:1|max:24',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'custom_installments' => 'nullable|array',
            'custom_installments.*.amount' => 'required_with:custom_installments|numeric|min:0',
            'custom_installments.*.due_date' => 'required_with:custom_installments|date',
            'custom_installments.*.status' => 'required_with:custom_installments|in:pending,paid'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'customer_id' => 'cliente',
            'payment_method_id' => 'método de pagamento',
            'sale_date' => 'data da venda',
            'installments' => 'número de parcelas',
            'notes' => 'observações',
            'items' => 'itens',
            'items.*.product_id' => 'produto',
            'items.*.quantity' => 'quantidade',
            'items.*.unit_price' => 'preço unitário',
            'total_amount' => 'valor total'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'items.required' => 'É necessário adicionar pelo menos um item à venda.',
            'items.min' => 'É necessário adicionar pelo menos um item à venda.',
            'items.*.product_id.required' => 'O produto é obrigatório.',
            'items.*.product_id.exists' => 'O produto selecionado não existe.',
            'items.*.quantity.required' => 'A quantidade é obrigatória.',
            'items.*.quantity.min' => 'A quantidade deve ser maior que zero.',
            'items.*.unit_price.required' => 'O preço unitário é obrigatório.',
            'items.*.unit_price.min' => 'O preço unitário deve ser maior ou igual a zero.',
            'installments.max' => 'O número máximo de parcelas é 24.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Calcular o total automaticamente baseado nos itens
        if ($this->has('items') && is_array($this->items)) {
            $total = 0;
            foreach ($this->items as $item) {
                if (isset($item['quantity']) && isset($item['unit_price'])) {
                    $total += $item['quantity'] * $item['unit_price'];
                }
            }
            $this->merge(['total_amount' => $total]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validar se o método de pagamento permite o número de parcelas solicitado
            if ($this->filled(['payment_method_id', 'installments'])) {
                $paymentMethod = \App\Models\PaymentMethod::find($this->payment_method_id);

                if ($paymentMethod && $this->installments > 1 && !$paymentMethod->allows_installments) {
                    $validator->errors()->add(
                        'installments',
                        'O método de pagamento selecionado não permite parcelamento.'
                    );
                }

                if ($paymentMethod && $this->installments > $paymentMethod->max_installments) {
                    $validator->errors()->add(
                        'installments',
                        "O método de pagamento permite no máximo {$paymentMethod->max_installments} parcelas."
                    );
                }
            }

            // Validar estoque dos produtos
            if ($this->has('items') && is_array($this->items)) {
                foreach ($this->items as $index => $item) {
                    if (isset($item['product_id']) && isset($item['quantity'])) {
                        $product = \App\Models\Product::find($item['product_id']);

                        if ($product && $product->stock < $item['quantity']) {
                            $validator->errors()->add(
                                "items.{$index}.quantity",
                                "Estoque insuficiente. Disponível: {$product->stock}"
                            );
                        }
                    }
                }
            }

            // Validar se a soma das parcelas personalizadas confere com o total
            if ($this->filled('custom_installments') && is_array($this->custom_installments)) {
                $totalAmount = (float) $this->total_amount;
                $installmentsTotal = 0;

                foreach ($this->custom_installments as $installment) {
                    if (isset($installment['amount'])) {
                        $installmentsTotal += (float) $installment['amount'];
                    }
                }

                $diff = abs($totalAmount - $installmentsTotal);
                if ($diff > 0.01) {
                    $validator->errors()->add(
                        'custom_installments',
                        'A soma das parcelas deve ser igual ao valor total da venda.'
                    );
                }
            }
        });
    }
}
