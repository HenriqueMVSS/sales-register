@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Nova Venda</h4>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Cliente</label>
                                    <select name="customer_id" id="customer_id" class="form-select">
                                        <option value="">Selecione um cliente (opcional)</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sale_date" class="form-label">Data da Venda <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date"
                                           value="{{ old('sale_date', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method_id" class="form-label">Método de Pagamento <span class="text-danger">*</span></label>
                                    <select name="payment_method_id" id="payment_method_id" class="form-select" required>
                                        <option value="">Selecione um método</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}"
                                                    data-allows-installments="{{ $method->allows_installments }}"
                                                    data-max-installments="{{ $method->max_installments }}"
                                                    {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                                {{ $method->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="installments" class="form-label">Número de Parcelas <span class="text-danger">*</span></label>
                                    <select name="installments" id="installments" class="form-select" required>
                                        <option value="1">1x à vista</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Observações</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <hr>

                        <h5>Itens da Venda</h5>
                        <div id="items-container">
                            <div class="item-row mb-3" data-index="0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Produto <span class="text-danger">*</span></label>
                                        <select name="items[0][product_id]" class="form-select product-select" required>
                                            <option value="">Selecione um produto</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                        data-price="{{ $product->price }}"
                                                        data-stock="{{ $product->stock }}">
                                                    {{ $product->name }} - R$ {{ number_format($product->price, 2, ',', '.') }} (Estoque: {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Quantidade <span class="text-danger">*</span></label>
                                        <input type="number" name="items[0][quantity]" class="form-control quantity-input"
                                               min="1" value="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Preço Unitário <span class="text-danger">*</span></label>
                                        <input type="number" name="items[0][unit_price]" class="form-control price-input"
                                               step="0.01" min="0" required readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Total do Item</label>
                                        <input type="text" class="form-control item-total" readonly>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-item" style="display: none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="button" id="add-item" class="btn btn-success">
                                <i class="fas fa-plus"></i> Adicionar Item
                            </button>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Total da Venda: <span id="total-amount">R$ 0,00</span></h5>
                                <input type="hidden" name="total_amount" id="total_amount_input" value="0">
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Salvar Venda
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    // Atualizar opções de parcelas baseado no método de pagamento
    document.getElementById('payment_method_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const allowsInstallments = selectedOption.dataset.allowsInstallments === '1';
        const maxInstallments = parseInt(selectedOption.dataset.maxInstallments) || 1;

        const installmentsSelect = document.getElementById('installments');
        installmentsSelect.innerHTML = '';

        if (allowsInstallments) {
            for (let i = 1; i <= maxInstallments; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i === 1 ? '1x à vista' : `${i}x`;
                installmentsSelect.appendChild(option);
            }
        } else {
            const option = document.createElement('option');
            option.value = 1;
            option.textContent = '1x à vista';
            installmentsSelect.appendChild(option);
        }
    });

    // Adicionar novo item
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newItem = container.children[0].cloneNode(true);

        newItem.dataset.index = itemIndex;
        newItem.querySelectorAll('select, input').forEach(function(field) {
            field.name = field.name.replace(/\[\d+\]/, `[${itemIndex}]`);
            if (field.type !== 'button') {
                field.value = '';
            }
        });

        newItem.querySelector('.remove-item').style.display = 'inline-block';
        newItem.querySelector('.item-total').value = 'R$ 0,00';

        container.appendChild(newItem);
        itemIndex++;

        // Atualizar eventos
        updateItemEvents();
        updateRemoveButtons();
    });

    // Remover item
    function removeItem(button) {
        button.closest('.item-row').remove();
        updateRemoveButtons();
        calculateTotal();
    }

    // Atualizar botões de remoção
    function updateRemoveButtons() {
        const items = document.querySelectorAll('.item-row');
        items.forEach(function(item, index) {
            const removeBtn = item.querySelector('.remove-item');
            if (items.length > 1) {
                removeBtn.style.display = 'inline-block';
                removeBtn.onclick = function() { removeItem(this); };
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    // Atualizar eventos dos itens
    function updateItemEvents() {
        document.querySelectorAll('.product-select').forEach(function(select) {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const priceInput = this.closest('.item-row').querySelector('.price-input');

                if (selectedOption.value) {
                    priceInput.value = selectedOption.dataset.price;
                } else {
                    priceInput.value = '';
                }

                calculateItemTotal(this.closest('.item-row'));
            });
        });

        document.querySelectorAll('.quantity-input, .price-input').forEach(function(input) {
            input.addEventListener('input', function() {
                calculateItemTotal(this.closest('.item-row'));
            });
        });
    }

    // Calcular total do item
    function calculateItemTotal(itemRow) {
        const quantity = parseFloat(itemRow.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(itemRow.querySelector('.price-input').value) || 0;
        const total = quantity * price;

        itemRow.querySelector('.item-total').value = 'R$ ' + total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        calculateTotal();
    }

    // Calcular total da venda
    function calculateTotal() {
        let total = 0;

        document.querySelectorAll('.item-row').forEach(function(itemRow) {
            const quantity = parseFloat(itemRow.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(itemRow.querySelector('.price-input').value) || 0;
            total += quantity * price;
        });

        document.getElementById('total-amount').textContent = 'R$ ' + total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        document.getElementById('total_amount_input').value = total;
    }

    // Inicializar eventos
    updateItemEvents();
    updateRemoveButtons();
});
</script>
@endsection
