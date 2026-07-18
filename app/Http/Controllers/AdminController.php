<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $todayOrders = Order::whereDate('created_at', today())->count();
        $inProgressOrders = Order::whereIn('status', ['Dijemput', 'Dicuci', 'Disetrika'])->count();
        $completedOrders = Order::where('status', 'Selesai')->count();
        $monthlyRevenue = Transaction::where('payment_status', 'Lunas')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('subtotal');
        $activeCustomers = Order::distinct('customer_whatsapp')->count('customer_whatsapp');
        $services = Service::where('is_active', true)->get();
        $recentOrders = Order::with(['service', 'transaction'])->latest()->take(6)->get();

        $weeklyOrderLabels = collect(range(6, 0))->reverse()->map(function ($dayOffset) {
            return Carbon::now()->subDays($dayOffset)->translatedFormat('D');
        })->values();
        $weeklyOrderData = collect(range(6, 0))->reverse()->map(function ($dayOffset) {
            $date = Carbon::now()->subDays($dayOffset)->toDateString();
            return Order::whereDate('created_at', $date)->count();
        })->values();

        $monthlyRevenueLabels = collect(range(1, 12))->map(function ($month) {
            return Carbon::create(now()->year, $month, 1)->translatedFormat('M');
        })->values();
        $monthlyRevenueData = collect(range(1, 12))->map(function ($month) {
            return (int) Transaction::where('payment_status', 'Lunas')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $month)
                ->sum('subtotal');
        })->values();

        $popularServices = Service::withCount('orders')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'todayOrders',
            'inProgressOrders',
            'completedOrders',
            'monthlyRevenue',
            'activeCustomers',
            'services',
            'recentOrders',
            'weeklyOrderLabels',
            'weeklyOrderData',
            'monthlyRevenueLabels',
            'monthlyRevenueData',
            'popularServices'
        ));
    }
}
