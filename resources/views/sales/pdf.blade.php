<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda #{{ $sale->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .document-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }

        .sale-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-left, .info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-right {
            text-align: right;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
        }

        .info-value {
            color: #666;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .installments-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .installments-table th, .installments-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        .installments-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .installments-table .text-right {
            text-align: right;
        }

        .installments-table .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 20px 0 10px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ config('app.name', 'Sistema de Vendas') }}</div>
        <div class="document-title">Relatório de Venda</div>
        <div>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="sale-info">
        <div class="info-left">
            <div class="info-group">
                <div class="info-label">Venda:</div>
                <div class="info-value">#{{ $sale->id }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Data da Venda:</div>
                <div class="info-value">{{ $sale->sale_date->format('d/m/Y') }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Cliente:</div>
                <div class="info-value">{{ $sale->customer ? $sale->customer->name : 'Cliente não informado' }}</div>
            </div>

            @if($sale->customer && $sale->customer->document)
            <div class="info-group">
                <div class="info-label">Documento:</div>
                <div class="info-value">{{ $sale->customer->document }}</div>
            </div>
            @endif

            @if($sale->customer && $sale->customer->phone)
            <div class="info-group">
                <div class="info-label">Telefone:</div>
                <div class="info-value">{{ $sale->customer->phone }}</div>
            </div>
            @endif
        </div>

        <div class="info-right">
            <div class="info-group">
                <div class="info-label">Vendedor:</div>
                <div class="info-value">{{ $sale->user->name }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Método de Pagamento:</div>
                <div class="info-value">{{ $sale->paymentMethod->name }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Parcelas:</div>
                <div class="info-value">{{ $sale->installments }}x</div>
            </div>

            <div class="info-group">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    @if($sale->status == 'completed')
                        <span class="badge badge-success">Concluída</span>
                    @elseif($sale->status == 'pending')
                        <span class="badge badge-warning">Pendente</span>
                    @else
                        <span class="badge badge-danger">Cancelada</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($sale->notes)
    <div class="info-group">
        <div class="info-label">Observações:</div>
        <div class="info-value">{{ $sale->notes }}</div>
    </div>
    @endif

    <div class="section-title">Itens da Venda</div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Produto</th>
                <th class="text-center">Qtd</th>
                <th class="text-right">Preço Unit.</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">TOTAL DA VENDA</td>
                <td class="text-right">R$ {{ number_format($sale->total_amount, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if($sale->installments > 1)
        <div class="section-title">Parcelas do Pagamento</div>
        <table class="installments-table">
            <thead>
                <tr>
                    <th class="text-center">Parcela</th>
                    <th class="text-right">Valor</th>
                    <th class="text-center">Vencimento</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->installments as $installment)
                    <tr>
                        <td class="text-center">{{ $installment->installment_number }}/{{ $sale->installments }}</td>
                        <td class="text-right">R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                        <td class="text-center">{{ $installment->due_date->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @if($installment->status == 'paid')
                                <span class="badge badge-success">Pago</span>
                            @elseif($installment->status == 'overdue')
                                <span class="badge badge-danger">Vencido</span>
                            @else
                                <span class="badge badge-warning">Pendente</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Este é um documento gerado automaticamente pelo sistema.</p>
        <p>{{ config('app.name', 'Sistema de Vendas') }} - {{ config('app.url', url('/')) }}</p>
    </div>
</body>
</html>
