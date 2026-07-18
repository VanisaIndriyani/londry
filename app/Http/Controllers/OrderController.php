<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Support\AdminSettings;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $services = Service::where('is_active', true)->get();

        if ($request->routeIs('admin.orders.create')) {
            return view('admin.orders.create', compact('services'));
        }

        return view('orders.create', compact('services'));
    }

    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'service_id' => 'required|exists:services,id',
            'notes' => 'nullable|string',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'status' => 'nullable|in:Menunggu Konfirmasi,Dijemput,Dicuci,Disetrika,Selesai,Diantar',
        ];

        if ($request->routeIs('admin.orders.store')) {
            $rules['weight'] = 'required|numeric|min:0';
        } else {
            $rules['weight'] = 'nullable|numeric|min:0';
        }

        $validated = $request->validate($rules);

        if (!$request->routeIs('admin.orders.store')) {
            unset($validated['status']);
            $validated['status'] = 'Menunggu Konfirmasi';
            $validated['weight'] = 0;
        }

        $order = Order::create($validated);

        if ($request->routeIs('admin.orders.store')) {
            return redirect()->route('admin.orders.show', $order)->with('success', 'Pesanan manual berhasil ditambahkan.');
        }

        $whatsappMessage = urlencode(
            "Halo Admin Laundry\n\n" .
            "Saya ingin memesan laundry.\n\n" .
            "Nomor Pesanan: {$order->order_number}\n" .
            "Nama: {$order->customer_name}\n" .
            "No WA: {$order->customer_whatsapp}\n" .
            "Alamat: {$order->customer_address}\n" .
            "Layanan: {$order->service->name}\n" .
            "Catatan: " . ($order->notes ?? '-') . "\n" .
            "Tanggal: {$order->pickup_date}\n" .
            "Jam: {$order->pickup_time}\n" .
            "Berat: ditimbang manual oleh admin\n" .
            "Pembayaran: dikonfirmasi manual via WhatsApp\n\n" .
            "Mohon konfirmasinya.\nTerima kasih."
        );

        $settings = AdminSettings::all();

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'whatsapp_url' => 'https://wa.me/' . AdminSettings::waMeNumber($settings['whatsapp'] ?? '') . "?text={$whatsappMessage}"
        ]);
    }

    public function checkStatus(Request $request)
    {
        $order = null;
        if ($request->has('order_number')) {
            $order = Order::where('order_number', $request->order_number)->with('service')->first();
        }
        return view('orders.check-status', compact('order'));
    }

    public function index(Request $request)
    {
        $query = Order::with(['service', 'transaction']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                    ->orWhere('customer_whatsapp', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('pickup_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('pickup_date', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10);
        $orders->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('service', 'transaction');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $services = Service::all();
        return view('admin.orders.edit', compact('order', 'services'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'status' => 'required|in:Menunggu Konfirmasi,Dijemput,Dicuci,Disetrika,Selesai,Diantar',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu Konfirmasi,Dijemput,Dicuci,Disetrika,Selesai,Diantar',
        ]);

        $order->update($validated);

        return response()->json(['success' => true]);
    }
}
