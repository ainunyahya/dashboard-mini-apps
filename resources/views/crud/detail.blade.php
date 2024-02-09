<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Nucleo Icons -->
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Date Range Picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.js"></script>
    <!-- DataTables and Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    <title>detail pesanan</title>
</head>
<body>
    <div class="container-fluid ">

    <div class="container">
        <div>
            <div class="row" style="padding-right: 10px">
                <div class="col-lg-12 margin-t">
                    <div class="pull-left d-flex justify-content-between align-items-center py-3">
                        <h2 style="font-family: 'Poppins Semi-Bold';">Detail Pesanan</h2>
                    </div>
                    <a href="{{ route('demo.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
            
            <!-- Main content -->
            <div class="row justify-content-centers">
                <div class="col-lg-8">
                    <!-- Details -->
                    <div class="card mb-4" style="border-radius: 15px;">
                        <div class="card-body">
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">ID :</h6>
                                <h6 style="font-family: 'Poppins Regular';">{{ $order->id }}</h6>
                            </div>
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">Tanggal order :</h6>
                                <h6 style="font-family: 'Poppins Regular';">{{ $order->order_time }}</h6>
                            </div>
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">pembayaran ke supplier :</h6>
                                <h6 style="font-family: 'Poppins Regular';">{{ $order->pay_to_supplier }}</h6>
                            </div>
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">Pembayaran dari user :</h6> 
                                <h6 style="font-family: 'Poppins Regular';">{{ $order->pay_from_customer }}</h6>
                            </div>
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">Nama :</h6>
                                <h6 style="font-family: 'Poppins Regular';">{{ optional($order->customer)->name }}</h6> 
                            </div>
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">Unit :</h6> 
                                <h6 style="font-family: 'Poppins Regular';">{{ optional(optional($order->customer)->unit)->name }}</h6>  
                            </div>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td><h6 style="font-family: 'Poppins Medium'; color: #000000;">Nama produk</h6></td>
                                        <td><h6 style="font-family: 'Poppins Medium'; color: #000000;">Jumlah</h6></td>
                                        <td><h6 style="font-family: 'Poppins Medium'; color: #000000;">Harga</h6></td>
                                    </tr>
                                    <tr>
                                    <td>
                                        @if($order->details instanceof \Illuminate\Database\Eloquent\Collection)
                                        <!-- Loop melalui koleksi details -->
                                        @foreach($order->details as $detail)
                                            <h6 style="font-family: 'Poppins Regular';">{{ optional($detail->product)->name }}</h6>
                                        @endforeach
                                        @else
                                            <!-- Asumsikan details adalah instance model tunggal -->
                                            <h6 style="font-family: 'Poppins Regular';">{{ optional(optional($order->details)->product)->name }}</h6>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->details instanceof \Illuminate\Database\Eloquent\Collection)
                                        <!-- Loop melalui koleksi details -->
                                        @foreach($order->details as $detail)
                                            <h6 style="font-family: 'Poppins Regular';">{{ $detail->qty }}</h6>
                                        @endforeach
                                        @else
                                            <!-- Asumsikan details adalah instance model tunggal -->
                                            <h6 style="font-family: 'Poppins Regular';">{{ optional($order->details)->qty }}</h6>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->details instanceof \Illuminate\Database\Eloquent\Collection)
                                        <!-- Loop melalui koleksi details -->
                                        @foreach($order->details as $detail)
                                            <h6 style="font-family: 'Poppins Regular';">{{ 'Rp. ' . number_format(optional($detail->product)->price_sale, 0, ',', '.') }}</h6>
                                        @endforeach
                                        @else
                                            <!-- Asumsikan details adalah instance model tunggal -->
                                            <h6 style="font-family: 'Poppins Regular';">{{ 'Rp. ' . number_format(optional(optional($order->details)->product)->price_sale, 0, ',', '.') }}</h6>
                                        @endif
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">Extra cost :</h6>
                                <h6 style="font-family: 'Poppins Regular';">{{ 'Rp. ' . number_format($order->extra_cost ?? 0, 0, ',', '.') }}</h6>
                            </div>
                            <div class=" mb-1 d-flex justify-content-between">
                                <h6 style="font-family: 'Poppins Medium'; color: #000000;">Total :</h6>
                                @php
                                    $total = 0; // variabel untuk menyimpan total
                                @endphp
                                <!-- Loop melalui koleksi details -->
                                @foreach($order->details as $detail)
                                    @php
                                        // Menghitung subtotal untuk setiap item
                                        $subtotal = $detail->qty * $detail->product->price_sale + $order->extra_cost; 
                                        // Menambahkan subtotal ke total
                                        $total += $subtotal; 
                                    @endphp
                                @endforeach
                                <h6 style="font-family: 'Poppins Regular';">{{ 'Rp. ' . number_format($total, 0, ',', '.') }}</h6>
                            </div>
                            <div class=" mb-1 d-flex justify-content-between">
                                @if($order->details instanceof \Illuminate\Database\Eloquent\Collection)
                                <!-- Loop melalui koleksi details -->
                                @foreach($order->details as $detail)
                                    <h6 style="font-family: 'Poppins Medium'; color: #000000;">Catatan :</h6>
                                    <h6 style="font-family: 'Poppins Regular';">{{ $detail->note }}</h6>
                                @endforeach
                                @else
                                    <!-- Asumsikan details adalah instance model tunggal -->
                                    <h6 style="font-family: 'Poppins Medium'; color: #000000;">Catatan :</h6> 
                                    <h6 style="font-family: 'Poppins Regular';">{{ optional($order->details)->note }}</h6>
                                @endif
                            </div>
                            <div class=" mb-4">
                                @if($order->details instanceof \Illuminate\Database\Eloquent\Collection)
                                <!-- Loop melalui koleksi details -->
                                @foreach($order->details as $detail)
                                    <h6 style="font-family: 'Poppins Medium'; color: #000000;">Alamat :</h6><br>
                                    <h6 style="font-family: 'Poppins Regular';">{{ $detail->address }}</h6>
                                @endforeach
                                @else
                                    <!-- Asumsikan details adalah instance model tunggal -->
                                    <h6 style="font-family: 'Poppins Medium'; color: #000000;">Alamat :</h6><br>
                                    <h6 style="font-family: 'Poppins Regular';">{{ optional($order->details)->address }}</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div> 

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>