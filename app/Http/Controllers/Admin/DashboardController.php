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
        $filter = $request->input('filter', 'all');
        $fromDate = null;
        $toDate = Carbon::now();
        $top10Users = [];
        $top10Users = DB::select(
            'SELECT
                `users`.`id`,
                `users`.`name`,
                SUM(orders.total_amount) AS total_revenue
            FROM
                `users`
                INNER JOIN `orders` ON `users`.`id` = `orders`.`user_id`
            WHERE
                `orders`.`status` = ?
                AND `users`.`deleted_at` IS NULL
            GROUP BY
                `users`.`id`,
                `users`.`name`
            ORDER BY
                `total_revenue` DESC,
                `users`.`created_at` DESC
            LIMIT
                10',
            ['completed']
        );
        switch ($filter) {
            case 'today':
                $fromDate = Carbon::today();
                $toDate = Carbon::today();
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
            case 'all': //  Xử lý lọc toàn bộ dữ liệu từ đơn hàng đầu tiên
                $firstOrder = Order::orderBy('created_at', 'asc')->first();
                if ($firstOrder) {
                    $fromDate = Carbon::parse($firstOrder->created_at)->startOfYear(); // Năm đầu tiên có đơn
                } else {
                    $fromDate = Carbon::now()->startOfYear(); // Nếu không có đơn hàng nào
                }

                break;
            default:
                return response()->json(['status' => 'error', 'message' => 'Bộ lọc không hợp lệ'], 400);
        }

        $orders = Order::whereBetween('created_at', [$fromDate, $toDate])->get();

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
                'products' => [], // Thêm mảng products
                'top10Users' => $top10Users ?? [], // Thêm mảng top10Users
            ]);
        }

        $totalOrders = $orders->count();
        $successfulOrders = $orders->where('status', 'completed')->count();
        $failedOrders = $orders->whereIn('status', ['cancelled'])->count();
        $pendingOrders = $totalOrders - $successfulOrders - $failedOrders;
        $totalRevenue = $orders->where('status', 'completed')->sum('total_amount');

        $revenueStats = [];
        $products = []; // Khởi tạo mảng $products

        if (in_array($filter, ['today', 'custom', 'week'])) {
            for ($i = 0; $i < 7; $i++) {
                $date = $statRange->copy()->addDays($i)->startOfDay();
                $dailyRevenue = Order::whereBetween('created_at', [$date, $date->copy()->endOfDay()])
                    ->where('status', 'completed')
                    ->sum('total_amount');
                $revenueStats[$date->format('d-m')] = $dailyRevenue;

                // Lấy thông tin sản phẩm trong khoảng thời gian này
                $dailyOrders = Order::whereBetween('created_at', [$date, $date->copy()->endOfDay()])->get();
                foreach ($dailyOrders as $order) {
                    foreach ($order->orderItems as $item) {
                        $productId = $item->productVariant->product->id; // Lấy ID sản phẩm
                        $productName = $item->productVariant->product->name;
                        if (isset($products[$productId])) {
                            $products[$productId]['quantity'] += $item->quantity;
                            $products[$productId]['total_price'] += $item->total_price;
                        } else {
                            $products[$productId]['quantity'] = $item->quantity;
                            $products[$productId]['total_price'] = $item->total_price;
                            $products[$productId]['product_name'] = $productName;
                        }
                    }
                }
            }
        } elseif ($filter === 'month') {
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();

            for ($date = $monthStart->copy(); $date->lte($monthEnd); $date->addDay()->startOfDay()) {
                $dailyRevenue = Order::whereBetween('created_at', [
                    $date->timezone('UTC'),
                    $date->copy()->endOfDay()->timezone('UTC')
                ])
                    ->where('status', 'completed')
                    ->sum('total_amount');
                $revenueStats[$date->format('d-m')] = $dailyRevenue;
                $dailyOrders = Order::whereBetween('created_at', [
                    $date->timezone('UTC'),
                    $date->copy()->endOfDay()->timezone('UTC')
                ])->get();
                foreach ($dailyOrders as $order) {
                    foreach ($order->orderItems as $item) {
                        $productId = $item->productVariant->product->id; // Lấy ID sản phẩm
                        $productName = $item->productVariant->product->name;
                        if (isset($products[$productId])) {
                            $products[$productId]['quantity'] += $item->quantity;
                            $products[$productId]['total_price'] += $item->total_price;
                        } else {
                            $products[$productId]['quantity'] = $item->quantity;
                            $products[$productId]['total_price'] = $item->total_price;
                            $products[$productId]['product_name'] = $productName;
                        }
                    }
                }
            }
        } elseif ($filter === 'year') {
            $currentYear = Carbon::now()->year;
            for ($i = 1; $i <= Carbon::now()->month; $i++) {
                $monthStart = Carbon::create($currentYear, $i, 1)->startOfMonth();
                $monthEnd = Carbon::create($currentYear, $i, 1)->endOfMonth();
                $monthlyRevenue = Order::whereBetween('created_at', [$monthStart, $monthEnd])
                    ->where('status', 'completed')
                    ->sum('total_amount');
                $revenueStats[$monthStart->format('m-Y')] = $monthlyRevenue;
                $monthlyOrders = Order::whereBetween('created_at', [$monthStart, $monthEnd])->get();
                foreach ($monthlyOrders as $order) {
                    foreach ($order->orderItems as $item) {
                        $productId = $item->productVariant->product->id; // Lấy ID sản phẩm
                        $productName = $item->productVariant->product->name;
                        if (isset($products[$productId])) {
                            $products[$productId]['quantity'] += $item->quantity;
                            $products[$productId]['total_price'] += $item->total_price;
                        } else {
                            $products[$productId]['quantity'] = $item->quantity;
                            $products[$productId]['total_price'] = $item->total_price;
                            $products[$productId]['product_name'] = $productName;
                        }
                    }
                }
            }
        } elseif ($filter === 'all') { //  Thống kê theo từng năm
            $firstYear = Carbon::parse($fromDate)->year;
            $currentYear = Carbon::now()->year;

            for ($year = $firstYear; $year <= $currentYear; $year++) {
                $yearStart = Carbon::create($year, 1, 1)->startOfYear();
                $yearEnd = Carbon::create($year, 12, 31)->endOfYear();
                $yearlyRevenue = Order::whereBetween('created_at', [$yearStart, $yearEnd])
                    ->where('status', 'completed')
                    ->sum('total_amount');
                $revenueStats[$year] = $yearlyRevenue;
                $yearlyOrders = Order::whereBetween('created_at', [$yearStart, $yearEnd])->get();
                foreach ($yearlyOrders as $order) {
                    foreach ($order->orderItems as $item) {
                        $productId = $item->productVariant->product->id; // Lấy ID sản phẩm
                        $productName = $item->productVariant->product->name;
                        if (isset($products[$productId])) {
                            $products[$productId]['quantity'] += $item->quantity;
                            $products[$productId]['total_price'] += $item->total_price;
                        } else {
                            $products[$productId]['quantity'] = $item->quantity;
                            $products[$productId]['total_price'] = $item->total_price;
                            $products[$productId]['product_name'] = $productName;
                        }
                    }
                }
            }
        }

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
            'products', // Pass $products to the view
            'top10Users' // Pass $top10Users to the view
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
        $filter = $request->input('filter', 'all');
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

        $labels = array_keys($customerStats);
        $dataCustomers = array_values($customerStats);
        $customerStats = json_encode($customerStats);

        return view('admin.dashboard.customer', compact(
            'totalCustomers',
            'totalRevenue',
            'successfulOrders',
            'customerStats',
            'labels',
            'dataCustomers',
            'customers'
        ));
    }
}
