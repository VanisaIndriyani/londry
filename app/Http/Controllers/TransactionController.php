<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('order')->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create(?int $orderId = null)
    {
        if (! $orderId) {
            return redirect()
                ->route('admin.orders.index')
                ->with('error', 'Pilih pesanan terlebih dahulu sebelum membuat transaksi.');
        }

        $order = Order::with(['service', 'transaction'])->findOrFail($orderId);

        if ((float) $order->weight <= 0) {
            return redirect()
                ->route('admin.orders.show', $order)
                ->with('error', 'Isi berat final terlebih dahulu sebelum membuat transaksi.');
        }

        if ($order->transaction) {
            return redirect()
                ->route('admin.transactions.show', $order->transaction)
                ->with('info', 'Transaksi untuk pesanan ini sudah tersedia.');
        }

        return view('admin.transactions.create', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'customer_name' => 'required|string|max:255',
            'total_weight' => 'required|numeric|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'payment_method' => 'required|in:Cash,Transfer,QRIS',
            'payment_status' => 'required|in:Belum Bayar,Lunas',
            'payment_date' => 'nullable|date',
            'proof_of_transfer' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $order = Order::with(['service', 'transaction'])->findOrFail($validated['order_id']);

        if ((float) $order->weight <= 0) {
            return redirect()
                ->route('admin.orders.edit', $order)
                ->with('error', 'Isi berat final terlebih dahulu sebelum menyimpan transaksi.');
        }

        if ($order->transaction) {
            return redirect()
                ->route('admin.transactions.show', $order->transaction)
                ->with('info', 'Transaksi untuk pesanan ini sudah dibuat sebelumnya.');
        }

        $validated['customer_name'] = $order->customer_name;
        $validated['total_weight'] = $order->weight;
        $validated['price_per_unit'] = $order->service->price;
        $validated['subtotal'] = $order->weight * $order->service->price;

        if ($request->hasFile('proof_of_transfer')) {
            $validated['proof_of_transfer'] = $request->file('proof_of_transfer')->store('proofs', 'public');
        }

        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('order');
        return view('admin.transactions.show', compact('transaction'));
    }
}
