<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Http\Requests\SaleRequest;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->middleware('auth');
        $this->saleService = $saleService;
    }

    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'paymentMethod', 'user'])
            ->latest();

        // Filtros
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('payment_method_id')) {
            $query->where('payment_method_id', $request->payment_method_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('sale_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('sale_date', '<=', $request->date_to);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $sales = $query->paginate(15);
        $customers = Customer::all();
        $paymentMethods = PaymentMethod::active()->get();
        $users = \App\Models\User::all();

        return view('sales.index', compact('sales', 'customers', 'paymentMethods', 'users'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::active()->get();
        $paymentMethods = PaymentMethod::active()->get();

        return view('sales.create', compact('customers', 'products', 'paymentMethods'));
    }

    public function store(SaleRequest $request)
    {
        try {
            $sale = $this->saleService->createSale($request->validated());

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Venda criada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao criar venda: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['customer', 'paymentMethod', 'user', 'saleItems.product', 'installmentRecords']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        $products = Product::active()->get();
        $paymentMethods = PaymentMethod::active()->get();
        $sale->load(['saleItems.product', 'installmentRecords']);

        return view('sales.edit', compact('sale', 'customers', 'products', 'paymentMethods'));
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        try {
            $sale = $this->saleService->updateSale($sale, $request->validated());

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Venda atualizada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao atualizar venda: ' . $e->getMessage());
        }
    }

    public function destroy(Sale $sale)
    {
        try {
            $sale->delete();
            return redirect()->route('sales.index')
                ->with('success', 'Venda excluída com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir venda: ' . $e->getMessage());
        }
    }

    public function generatePDF(Sale $sale)
    {
        $sale->load(['customer', 'paymentMethod', 'user', 'saleItems.product', 'installmentRecords']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('sales.pdf', compact('sale'));

        return $pdf->download('venda-' . $sale->id . '.pdf');
    }
}
