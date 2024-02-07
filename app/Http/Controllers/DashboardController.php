<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index()
    {
        $result = Order::selectRaw('
            DATE_FORMAT(orders.order_time, "%Y-%m") AS bulan_tahun,
            SUM(orders_detail.qty * products.price_sale) AS total_pendapatan,
            SUM(orders_detail.qty * products.price_buy) AS total_pembelian,
            SUM((orders_detail.qty * products.price_sale) - (orders_detail.qty * products.price_buy)) AS total_komisi,
            SUM(CASE WHEN orders.pay_from_customer IS NULL THEN (orders_detail.qty * products.price_sale) ELSE 0 END) AS total_piutang,
            SUM(CASE WHEN orders.pay_to_supplier IS NULL THEN (orders_detail.qty * products.price_sale) ELSE 0 END) AS total_hutang
        ')
            ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
            ->join('products', 'orders_detail.product_id', '=', 'products.id')
            ->groupBy('bulan_tahun')
            ->orderBy('bulan_tahun')
            ->get();

        $result3 = Order::selectRaw('
            DATE_FORMAT(orders.order_time, "%Y-%m") AS bulan_tahun,
            SUM(orders.extra_cost) AS total_biaya_tambahan,
            SUM(products.discount) AS total_diskon
        ')
            ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
            ->join('products', 'orders_detail.product_id', '=', 'products.id')
            ->groupBy('bulan_tahun')
            ->orderBy('bulan_tahun')
            ->get();

        return view('dashboard', [
            'result' => $result,
            'result3' => $result3
        ]);
    }
}
