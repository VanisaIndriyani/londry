<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'month');
        $startDate = null;
        $endDate = null;

        switch ($filter) {
            case 'day':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
        }

        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedOrders = Order::where('status', 'Selesai')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalRevenue = Transaction::where('payment_status', 'Lunas')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('subtotal');

        $mostPopularService = Service::withCount(['orders' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        }])->orderBy('orders_count', 'desc')->first();

        $paymentMethodSummary = [
            'Cash' => Transaction::where('payment_status', 'Lunas')->where('payment_method', 'Cash')->whereBetween('created_at', [$startDate, $endDate])->sum('subtotal'),
            'Transfer' => Transaction::where('payment_status', 'Lunas')->where('payment_method', 'Transfer')->whereBetween('created_at', [$startDate, $endDate])->sum('subtotal'),
            'QRIS' => Transaction::where('payment_status', 'Lunas')->where('payment_method', 'QRIS')->whereBetween('created_at', [$startDate, $endDate])->sum('subtotal'),
        ];

        $serviceBreakdown = Service::withCount(['orders' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        }])->orderByDesc('orders_count')->take(5)->get();

        return view('admin.reports.index', compact(
            'totalOrders',
            'completedOrders',
            'totalRevenue',
            'mostPopularService',
            'paymentMethodSummary',
            'serviceBreakdown',
            'filter'
        ));
    }
}
