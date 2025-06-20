@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Venda #{{ $sale->id }}</h4>
                    <div>
                        <a href="{{ route('sales.pdf', $sale) }}" class="btn btn-info">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Informações da Venda -->
                        <div class="col-md-6">
                            <h5>Informações da Venda</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Data:</strong></td>
                                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($sale->status == 'completed')
                                            <span class="badge bg-success">Concluída</span>
                                        @elseif($sale->status == 'pending')
                                            <span class="badge bg-warning">Pendente</span>
                                        @else
                                            <span class="badge bg-danger">Cancelada</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Vendedor:</strong></td>
                                    <td>{{ $sale->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cliente:</strong></td>
                                    <td>{{ $sale->customer ? $sale->customer->name : 'Cliente não informado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Método de Pagamento:</strong></td>
                                    <td>{{ $sale->paymentMethod->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Parcelas:</strong></td>
                                    <td>{{ $sale->installments }}x</td>
                                </tr>
                                @if($sale->notes)
                                <tr>
                                    <td><strong>Observações:</strong></td>
                                    <td>{{ $sale->notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <!-- Resumo Financeiro -->
                        <div class="col-md-6">
                            <h5>Resumo Financeiro</h5>
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="text-primary">R$ {{ number_format($sale->total_amount, 2, ',', '.') }}</h3>
                                    <p class="mb-0">Total da Venda</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Itens da Venda -->
                    <h5>Itens da Venda</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Preço Unitário</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                        <td>R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <th colspan="3">Total da Venda</th>
                                    <th>R$ {{ number_format($sale->total_amount, 2, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($sale->installments > 1)
                        <hr>

                        <!-- Parcelas -->
                        <h5>Parcelas</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Parcela</th>
                                        <th>Valor</th>
                                        <th>Vencimento</th>
                                        <th>Status</th>
                                        <th>Data Pagamento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->installments as $installment)
                                        <tr>
                                            <td>{{ $installment->installment_number }}/{{ $sale->installments }}</td>
                                            <td>R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                                            <td>{{ $installment->due_date->format('d/m/Y') }}</td>
                                            <td>
                                                @if($installment->status == 'paid')
                                                    <span class="badge bg-success">Pago</span>
                                                @elseif($installment->status == 'overdue')
                                                    <span class="badge bg-danger">Vencido</span>
                                                @else
                                                    <span class="badge bg-warning">Pendente</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $installment->paid_date ? $installment->paid_date->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
