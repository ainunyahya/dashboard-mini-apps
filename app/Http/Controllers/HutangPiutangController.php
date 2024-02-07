<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HutangPiutangController extends Controller
{
    function index()
    {
        $result = DB::table('orders')
            ->select(
                DB::raw("DATE_FORMAT(orders.order_time, '%Y-%m') AS tanggal"),
                DB::raw("SUM(CASE WHEN orders.pay_from_customer IS NULL THEN (orders_detail.qty * products.price_sale) ELSE 0 END) AS total_qty_1"),
                DB::raw("SUM(CASE WHEN orders.pay_to_supplier IS NULL THEN (orders_detail.qty * products.price_sale) ELSE 0 END) AS total_qty_2")
            )
            ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
            ->join('products', 'orders_detail.product_id', '=', 'products.id')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    
        // Your original query
        $result1 = Unit::select('units.name AS unit_name', 
            DB::raw("SUM(CASE WHEN orders.pay_from_customer IS NULL THEN (orders_detail.qty * products.price_sale) ELSE 0 END) AS total_amount"))
        ->join('customers', 'units.id', '=', 'customers.unit_id')
        ->join('orders', 'customers.id', '=', 'orders.customer_id')
        ->join('orders_detail', 'orders_detail.order_id', '=', 'orders.id')
        ->join('products', 'orders_detail.product_id', '=', 'products.id')
        ->groupBy('units.name')
        ->orderByDesc('total_amount')
        ->limit(5)
        ->get();


        // Query 2
        $result2 = Supplier::select('suppliers.name AS nama_vendor',
                DB::raw("SUM(CASE WHEN orders.pay_to_supplier IS NULL THEN (orders_detail.qty * products.price_sale) ELSE 0 END) AS total_hutang"))
            ->join('products', 'products.supplier_id', '=', 'suppliers.id')
            ->join('orders_detail', 'orders_detail.product_id', '=', 'products.id')
            ->join('orders', 'orders_detail.order_id', '=', 'orders.id')
            ->where('suppliers.name', '!=', 'ITSMINE') 
            ->groupBy('suppliers.name')
            ->orderByDesc('total_hutang')
            ->limit(5)
            ->get();

        // Convert the results to an array for use in JavaScript
        $chartData = json_encode($result);
        $chartData1 = json_encode($result1);
        $chartData2 = json_encode($result2);

        return view('hutangpiutang', compact('chartData', 'chartData1', 'chartData2'));
    }
}
