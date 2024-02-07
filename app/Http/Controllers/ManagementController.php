<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Management;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManagementController extends Controller
{
    public function index()
    {
        // +++++++ awal query chart pendapatan, pembelian, komisi +++++++
        $result = DB::table('orders')
        ->select(
            DB::raw("DATE_FORMAT(orders.order_time, '%Y-%m') AS bulan_tahun"),
            DB::raw("SUM(orders_detail.qty * products.price_sale) AS total_pendapatan"),
            DB::raw("SUM(orders_detail.qty * products.price_buy) AS total_pembelian"),
            DB::raw("SUM((orders_detail.qty * products.price_sale) - (orders_detail.qty * products.price_buy)) AS total_komisi")
        )
        ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
        ->join('products', 'orders_detail.product_id', '=', 'products.id')
        ->groupBy(DB::raw("DATE_FORMAT(orders.order_time, '%Y-%m')"))
        ->orderBy(DB::raw("DATE_FORMAT(orders.order_time, '%Y-%m')"))
        ->get();

        $result1 = Order::selectRaw("DATE_FORMAT(orders.order_time, '%Y-%m') AS bulan_tahun")
        ->selectRaw("SUM(CASE WHEN products.id NOT IN (1, 2, 4, 33) THEN orders_detail.qty * products.price_sale ELSE 0 END) AS total_pendapatan")
        ->selectRaw("SUM(CASE WHEN products.id NOT IN (1, 2, 4, 33) THEN orders_detail.qty * products.price_buy ELSE 0 END) AS total_pembelian")
        ->selectRaw("SUM(CASE WHEN products.id NOT IN (1, 2, 4, 33) THEN (orders_detail.qty * products.price_sale) - (orders_detail.qty * products.price_buy) ELSE 0 END) AS total_komisi")
        ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
        ->join('products', 'orders_detail.product_id', '=', 'products.id')
        ->whereNotIn('products.id', [1, 2, 4, 33])
        ->groupByRaw("DATE_FORMAT(orders.order_time, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(orders.order_time, '%Y-%m')")
        ->get();

        $result2 = Order::selectRaw("DATE_FORMAT(orders.order_time, '%Y-%m') AS bulan_tahun")
        ->selectRaw("SUM(CASE WHEN products.id IN (1, 2, 4, 33) THEN orders_detail.qty * products.price_sale ELSE 0 END) AS total_pendapatan")
        ->selectRaw("SUM(CASE WHEN products.id IN (1, 2, 4, 33) THEN orders_detail.qty * products.price_buy ELSE 0 END) AS total_pembelian")
        ->selectRaw("SUM(CASE WHEN products.id IN (1, 2, 4, 33) THEN (orders_detail.qty * products.price_sale) - (orders_detail.qty * products.price_buy) ELSE 0 END) AS total_komisi")
        ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
        ->join('products', 'orders_detail.product_id', '=', 'products.id')
        ->whereIn('products.id', [1, 2, 4, 33])
        ->groupByRaw("DATE_FORMAT(orders.order_time, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(orders.order_time, '%Y-%m')")
        ->get();
        // ------- akhir query chart pendapatan, pembelian, komisi --------
        
        // +++++++ awal query chart extra cost, diskon ++++++++
        $result3 = Order::selectRaw("DATE_FORMAT(order_time, '%Y-%m') AS bulan_tahun")
        ->selectRaw("SUM(orders.extra_cost) AS total_biaya_tambahan")
        ->selectRaw("SUM(products.discount) AS total_diskon")
        ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
        ->join('products', 'orders_detail.product_id', '=', 'products.id')
        ->groupByRaw("DATE_FORMAT(order_time, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(order_time, '%Y-%m')")
        ->get();

        $result4 = Order::selectRaw("DATE_FORMAT(order_time, '%Y-%m') AS bulan_tahun")
        ->selectRaw("SUM(orders.extra_cost) AS total_biaya_tambahan")
        ->selectRaw("SUM(products.discount) AS total_diskon")
        ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
        ->join('products', 'orders_detail.product_id', '=', 'products.id')
        ->whereNotIn('products.id', [1, 2, 4, 33])
        ->groupByRaw("DATE_FORMAT(order_time, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(order_time, '%Y-%m')")
        ->get();

        $result5 = Order::selectRaw("DATE_FORMAT(order_time, '%Y-%m') AS bulan_tahun")
        ->selectRaw("SUM(orders.extra_cost) AS total_biaya_tambahan")
        ->selectRaw("SUM(products.discount) AS total_diskon")
        ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
        ->join('products', 'orders_detail.product_id', '=', 'products.id')
        ->whereIn('products.id', [1, 2, 4, 33])
        ->groupByRaw("DATE_FORMAT(order_time, '%Y-%m')")
        ->orderByRaw("DATE_FORMAT(order_time, '%Y-%m')")
        ->get();

        // ------- akhir query chart extra cost, diskon --------

        
        //dd($result);

        // Handle hasil query sesuai kebutuhan Anda
        return view('management', [
            'result' => $result, 
            'result1' => $result1, 
            'result2' => $result2,
            'result3' => $result3,
            'result4' => $result4,
            'result5' => $result5
        ]);
    }
}
