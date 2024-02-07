<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Unit;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DemoController extends Controller
{
    public function index()
    {
        $data = Order::with('details', 'customer.unit')
            ->select('orders.id', 'orders.order_time', 'customers.name as user_name', 'units.name as unit_name', 'orders_detail.qty', 'products.price_sale', 'orders.extra_cost')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('units', 'customers.unit_id', '=', 'units.id')
            ->join('orders_detail', 'orders.id', '=', 'orders_detail.order_id')
            ->join('products', 'products.id', '=', 'orders_detail.product_id')
            ->orderBy('orders.id', 'desc')
            ->orderByDesc('orders.order_time')
            ->get();
    
        return view('demo', ['data' => $data]);
    }
    
    public function create()
    {
        $datas = DB::table('products')
            ->select('id', 'name', 'discount')
            ->get();

        $datas1 = DB::table('units')
        ->select('id', 'name')
        ->get();
        
        return view('crud.create', compact('datas', 'datas1'));
    }
    
    public function store(Request $request) 
    {

        // Dapatkan price_sale berdasarkan product_id
        $product = Product::find($request->input('product_id'));
        $price_sale = $product->price_sale;

        // Simpan data ke dalam tabel users
        $user = Customer::create([
            'name' => $request->input('user_name'),
            'unit_id' => $request->input('unit_name'),
        ]);

        // Simpan data ke dalam tabel orders
        $order = Order::create([
            'order_time' => now(),
            'user_id' => $user->id,
            'extra_cost' => $request->input('extra_cost'),
        ]);

        // Simpan data ke dalam tabel orders_detail
        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $request->input('product_id'),
            'price_sale' => $price_sale,
            'qty' => $request->input('qty'),
            'note' => $request->input('note'),
            'address' => $request->input('address'),
        ]);

        //dd($request->all());

        // Tambahkan logika atau redirect ke halaman yang diinginkan setelah penyimpanan sukses
        return redirect()->route('demo.index')->with('success', 'Order berhasil ditambahkan!');
    }

    public function show($id)
    {
        $order = Order::with(['customer.unit', 'details.product'])->find($id);

        // Pastikan order dengan ID tersebut ada
        if (!$order) {
            abort(404);
        }
        return view('crud.detail', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with(['customer.unit', 'details.product'])->find($id);

        // Gantilah 'OrderEdit' dengan nama blade yang sesuai
        return view('crud.edit', compact('order'));
    }

    public function update(Request $request, $id) 
    {
        // Temukan order yang akan diperbarui
        $order = Order::find($id);

        // Pastikan order dengan ID tersebut ada
        if (!$order) {
            abort(404);
        }

        // Simpan perubahan ke dalam model Order
        $order->pay_to_supplier = $request->input('vendor_payment');
        $order->pay_from_customer = $request->input('user_payment');
        $order->save();

        return redirect()->route('demo.edit', $order->id)->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pesanan = Order::find($id);

        if (!$pesanan) {
            return redirect()->route('nama_route_index')->with('error', 'Pesanan tidak ditemukan.');
        }

        $pesanan->delete();

        return redirect()->route('nama_route_index')->with('success', 'Pesanan berhasil dihapus.');
    }

}
