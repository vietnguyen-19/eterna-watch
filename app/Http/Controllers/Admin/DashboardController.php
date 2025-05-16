<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function revenue(Request $request)
    {

        $filter = $request->input('filter', 'month');
        $fromDate = null;
        $toDate = Carbon::now();

        // Top 10 users with net revenue (total_amount - total_refund_amount from refunds table)
        $top10Users = DB::select(
            'SELECT
                orders.order_user_id,
                orders.name,
                SUM(orders.total_amount - COALESCE(refunds.total_refund_amount, 0)) AS total_revenue
            FROM
                orders
                LEFT JOIN refunds ON orders.id = refunds.order_id
            WHERE
                orders.status = ?
            GROUP BY
                orders.order_user_id,
                orders.name
            ORDER BY
                total_revenue DESC
            LIMIT 10
            ',
            ['completed']
        );

        // Set date range based on filter
        switch ($filter) {
            case 'today':
                $fromDate = Carbon::today();
                $toDate = Carbon::today()->endOfDay();
                $statRange = Carbon::now()->copy()->subDays(6);
                break;
            case 'custom':
                $fromDate = Carbon::parse($request->input('from_date', Carbon::now()))->startOfDay();
                $toDate = Carbon::parse($request->input('to_date', Carbon::now()))->endOfDay();
                $statRange = Carbon::now()->copy()->subDays(6);
                break;
            case 'week':
                $fromDate = Carbon::now()->startOfWeek();
                $toDate = Carbon::now()->endOfWeek();
                $statRange = Carbon::now()->copy()->subDays(6);
                break;
            case 'month':
                $fromDate = Carbon::now()->startOfMonth();
                $toDate = Carbon::now()->endOfMonth();
                $statRange = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $fromDate = Carbon::now()->startOfYear();
                $toDate = Carbon::now()->endOfYear();
                $statRange = Carbon::now()->startOfYear();
                break;
            case 'all':
                $firstOrder = Order::orderBy('created_at', 'asc')->first();
                $fromDate = $firstOrder ? Carbon::parse($firstOrder->created_at)->startOfYear() : Carbon::now()->startOfYear();
                $toDate = Carbon::now()->endOfDay();
                $statRange = $fromDate->copy();
                break;
            default:
                return response()->json(['status' => 'error', 'message' => 'Bộ lọc không hợp lệ'], 400);
        }

        // Lấy top 10 người dùng doanh thu cao nhất
        $top10Users = DB::select(
            'SELECT
                orders.order_user_id,
                orders.name,
                SUM(orders.total_amount - COALESCE(refunds.total_refund_amount, 0)) AS total_revenue
            FROM
                orders
                LEFT JOIN refunds ON orders.id = refunds.order_id
            WHERE
                orders.status = ?
                AND orders.created_at BETWEEN ? AND ?
            GROUP BY
                orders.order_user_id,
                orders.name
            ORDER BY
                total_revenue DESC
            LIMIT 10',
            ['completed', $fromDate, $toDate]
        );

        $orders = Order::whereBetween('created_at', [$fromDate, $toDate])->get();


        // Return empty data if no orders
        if ($orders->isEmpty()) {
            return view('admin.dashboard.revenue', [
                'totalOrders' => 0,
                'successfulOrders' => 0,
                'pendingOrders' => 0,
                'failedOrders' => 0,
                'totalRevenue' => 0,
                'revenueStats' => [],
                'orders' => [],
                'labels' => [],
                'dataDoanhThu' => [],
                'topProducts' => [],
                'products' => [],
                'top10Users' => $top10Users ?? [],
            ]);
        }

        // Calculate order metrics
        $totalOrders = $orders->count();
        $successfulOrders = $orders->where('status', 'completed')->count();
        $failedOrders = $orders->whereIn('status', ['cancelled'])->count();
        $pendingOrders = $totalOrders - $successfulOrders - $failedOrders;

        // Calculate total revenue using DB query
        $totalRevenue = DB::table('orders')
            ->leftJoin('refunds', 'orders.id', '=', 'refunds.order_id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->sum(DB::raw('orders.total_amount - COALESCE(refunds.total_refund_amount, 0)'));

        $revenueStats = [];
        $products = [];

        // Calculate revenue stats based on filter
        if (in_array($filter, ['today', 'custom', 'week'])) {
            for ($i = 0; $i < 7; $i++) {
                $date = $statRange->copy()->addDays($i)->startOfDay();
                $endDate = $date->copy()->endOfDay();

                $dailyRevenue = Order::whereBetween('orders.created_at', [$date, $endDate])
                    ->where('orders.status', 'completed')
                    ->leftJoin('refunds', 'orders.id', '=', 'refunds.order_id')
                    ->sum(DB::raw('orders.total_amount - COALESCE(refunds.total_refund_amount, 0)'));
                $revenueStats[$date->format('d-m')] = $dailyRevenue;
            }
        } elseif ($filter === 'month') {
            $date = $fromDate->copy();
            while ($date->lte($toDate)) {
                $startDay = $date->copy()->startOfDay();
                $endDay = $date->copy()->endOfDay();

                $dailyRevenue = Order::whereBetween('orders.created_at', [$startDay, $endDay])
                    ->where('orders.status', 'completed')
                    ->leftJoin('refunds', 'orders.id', '=', 'refunds.order_id')
                    ->sum(DB::raw('orders.total_amount - COALESCE(refunds.total_refund_amount, 0)'));
                $revenueStats[$date->format('d-m')] = $dailyRevenue;

                $date->addDay();
            }
        } elseif ($filter === 'year') {
            $currentYear = Carbon::now()->year;
            for ($i = 1; $i <= Carbon::now()->month; $i++) {
                $monthStart = Carbon::create($currentYear, $i, 1)->startOfMonth();
                $monthEnd = Carbon::create($currentYear, $i, 1)->endOfMonth();

                $monthlyRevenue = Order::whereBetween('orders.created_at', [$monthStart, $monthEnd])
                    ->where('orders.status', 'completed')
                    ->leftJoin('refunds', 'orders.id', '=', 'refunds.order_id')
                    ->sum(DB::raw('orders.total_amount - COALESCE(refunds.total_refund_amount, 0)'));

                $revenueStats[$monthStart->format('m-Y')] = $monthlyRevenue;
            }
        } elseif ($filter === 'all') {
            $firstYear = Carbon::parse($fromDate)->year;
            $currentYear = Carbon::now()->year;
            for ($year = $firstYear; $year <= $currentYear; $year++) {
                $yearStart = Carbon::create($year, 1, 1)->startOfYear();
                $yearEnd = Carbon::create($year, 12, 31)->endOfYear();

                $yearlyRevenue = Order::whereBetween('orders.created_at', [$yearStart, $yearEnd])
                    ->where('orders.status', 'completed')
                    ->leftJoin('refunds', 'orders.id', '=', 'refunds.order_id')
                    ->sum(DB::raw('orders.total_amount - COALESCE(refunds.total_refund_amount, 0)'));

                $revenueStats[$year] = $yearlyRevenue;
            }
        }

        // Thống kê top sản phẩm bán chạy
        $completedOrders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->with('orderItems.productVariant.product')
            ->get();

        $products = [];

        foreach ($completedOrders as $order) {
            foreach ($order->orderItems as $item) {
                // Dùng thông tin lưu trong order_items để hiển thị
                $productName = $item->product_name;
                $productKey = $item->product_name; // Dùng tên sản phẩm làm key để gom nhóm

                // Nếu sản phẩm đã bị xóa, thêm tag cảnh báo
                if (empty(optional($item->productVariant->product)->id)) {
                    $productName .= ' <small class="text-danger">(Đã xóa)</small>';
                }

                if (!isset($products[$productKey])) {
                    $products[$productKey] = [
                        'product_name' => $productName,
                        'quantity' => 0,
                        'total_price' => 0
                    ];
                }

                $products[$productKey]['quantity'] += $item->quantity;
                $products[$productKey]['total_price'] += $item->total_price;
            }
        }

        $topProducts = collect($products)
            ->sortByDesc('quantity')
            ->take(10)
            ->values()
            ->all();

        // Sắp xếp sản phẩm theo số lượng bán được (giảm dần)
        $topProducts = collect($products)->sortByDesc('quantity')->take(10)->values()->all();

        $labels = array_keys($revenueStats);
        $dataDoanhThu = array_values($revenueStats);
        $revenueStats = json_encode($revenueStats);

        return view('admin.dashboard.revenue', compact(
            'totalOrders',
            'successfulOrders',
            'failedOrders',
            'pendingOrders',
            'totalRevenue',
            'revenueStats',
            'labels',
            'dataDoanhThu',
            'orders',
            'products',
            'topProducts',
            'top10Users'
        ));
    }
    public function stock()
    {
        $variants = ProductVariant::with('product', 'attributeValues.nameValue.attribute')
            ->where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->get();

        return view('admin.dashboard.stock', [
            'variants' => $variants
        ]);
    }
    public function customer(Request $request)
    {
        $filter = $request->input('filter', 'month');
        $fromDate = null;
        $toDate = Carbon::now();


        switch ($filter) {
            case 'all':
                $firstCustomer = User::where('role_id', 3)->orderBy('created_at')->first();
                if ($firstCustomer) {
                    $fromDate = Carbon::parse($firstCustomer->created_at)->startOfYear();
                } else {
                    $fromDate = Carbon::now()->startOfYear();
                }
                $statRange = $fromDate->copy();
                break;
            case 'today':
            case 'custom':
                $fromDate = Carbon::parse($request->input('from_date', Carbon::now()))->startOfDay();
                $toDate = Carbon::parse($request->input('to_date', Carbon::now()))->endOfDay();
                $statRange = Carbon::now()->copy()->subDays(6);
                break;
            case 'week':
                $fromDate = Carbon::now()->startOfWeek();
                $statRange = Carbon::now()->copy()->subDays(6);
                break;
            case 'month':
                $fromDate = Carbon::now()->startOfMonth();
                $statRange = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $fromDate = Carbon::now()->startOfYear();
                $statRange = Carbon::now()->startOfYear();
                break;
            default:
                return response()->json(['status' => 'error', 'message' => 'Bộ lọc không hợp lệ'], 400);
        }

        // Lấy danh sách khách hàng đăng ký trong khoảng thời gian
        $customers = User::with('orders')->where('role_id', 3)
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();

        if ($customers->isEmpty()) {
            return view('admin.dashboard.customer', [
                'totalCustomers' => 0,
                'totalRevenue' => 0,
                'successfulOrders' => 0,
                'customerStats' => json_encode([]),
                'labels' => [],
                'dataCustomers' => [],
                'customers' => [],
            ]);
        }

        // Thêm thông tin số đơn hàng và tổng tiền đã chi của từng khách hàng
        $customers->map(function ($customer) use ($fromDate, $toDate) {
            $customer->total_orders = Order::where('user_id', $customer->id)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->count();
            $customer->total_completed_orders = Order::where('user_id', $customer->id)
                ->where('status', 'completed')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->count();
            $customer->total_spent = Order::where('user_id', $customer->id)
                ->where('status', 'completed')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->sum('total_amount');

            return $customer;
        });

        $totalCustomers = $customers->count();
        $customerIds = $customers->pluck('id');

        // Tính số đơn hàng của tài khoản mới
        $successfulOrders = Order::whereIn('user_id', $customerIds)
            ->where('status', 'completed')
            ->count();
        $cancelledOrders = Order::whereIn('user_id', $customerIds)
            ->where('status', 'cancalled')
            ->count();

        // Tính doanh thu từ tài khoản mới
        $totalRevenue = Order::whereIn('user_id', $customerIds)
            ->where('status', 'completed')
            ->sum('total_amount');
        $customerStats = [];

        // Xử lý thống kê theo từng khoảng thời gian
        if (in_array($filter, ['today', 'custom', 'week', 'month'])) {
            $endRange = ($filter === 'month') ? $toDate->copy() : $statRange->copy()->addDays(6);
            while ($statRange->lte($endRange)) {
                $count = User::where('role_id', 3)
                    ->whereBetween('created_at', [$statRange->copy()->startOfDay(), $statRange->copy()->endOfDay()])
                    ->count();
                $customerStats[$statRange->format('d-m')] = $count;
                $statRange->addDay();
            }
        } elseif ($filter === 'year') {
            for ($i = 1; $i <= 12; $i++) {
                $monthStart = Carbon::create(null, $i, 1)->startOfMonth();
                $monthEnd = Carbon::create(null, $i, 1)->endOfMonth();

                $count = User::where('role_id', 3)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->count();

                $customerStats[$monthStart->format('m-Y')] = $count;
            }
        } elseif ($filter === 'all') {
            $currentYear = Carbon::now()->year;
            while ($statRange->year <= $currentYear) {
                $yearStart = $statRange->copy()->startOfYear();
                $yearEnd = $statRange->copy()->endOfYear();

                $count = User::where('role_id', 3)
                    ->whereBetween('created_at', [$yearStart, $yearEnd])
                    ->count();

                $customerStats[$yearStart->format('Y')] = $count;
                $statRange->addYear();
            }
        }

        $topCustomers = DB::table('orders')
            ->select([
                'orders.order_user_id as user_id',
                'orders.name as customer_name',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_spent'),
            ])
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->groupBy('orders.order_user_id', 'orders.name')
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                // đánh dấu (Đã xóa) nếu user record thật sự đã không còn
                $exists = \App\Models\User::where('id', $row->user_id)->exists();
                if (!$exists) {
                    $row->customer_name .= ' <small class="text-danger">(Đã xóa)</small>';
                }
                return $row;
            });

        // --- Chuẩn bị gửi về view ---
        $labels       = array_keys($customerStats ?? []);
        $dataCustomers = array_values($customerStats ?? []);

        return view('admin.dashboard.customer', compact(
            'totalCustomers',
            'totalRevenue',
            'successfulOrders',
            'customerStats',
            'labels',
            'dataCustomers',
            'customers',
            'topCustomers'   // đừng quên truyền thêm biến này
        ));
    }
}
