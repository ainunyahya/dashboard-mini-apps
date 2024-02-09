@extends('layouts.master')

@section('content')

<style>
    .dropdown-menu {
        text-align: center;
    }

    .dropdown-menu li {
        display: block;
        
    /* CSS untuk mengatur ukuran tombol Next dan Previous */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: 14px; /* Atur ukuran font */
        padding: 6px 10px; /* Atur padding tombol */

    }
</style>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-family: 'Poppins Semi-Bold';">Pesanan</h2>
        </div>
        <a href="demo/create" class="btn btn-success">Buat</a>
    </div>
</div>
    <div class="card-body mb-4 p-4 bg-white" style="width: 100%;  border-radius: 10px;">
        <div class="table-container p-1" style="width: 100%">
            <table id="example" class="table table-striped table-bordered table-hover" style="width:100%; font-size: 12px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Unit</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_time }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ $order->unit_name }}</td>
                            <td>
                                @php
                                    $total = 0;
                                    foreach($order->details as $detail) {
                                        $total += $detail->qty * (optional($detail->product)->price_sale) + $order->extra_cost;
                                    }
                                    echo 'Rp. ' . number_format($total, 0, ',', '.');
                                @endphp
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    button
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                          <a class="dropdown-item" href="{{ route('detail.show', $order->id) }}">detail</a>
                                        </li>
                                        <li>
                                          <a class="dropdown-item" href="{{ route('demo.edit', $order->id) }}">Edit</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('demo.destroy', $order->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')" class="dropdown-item">
                                                    Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                  </div>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[0, 'desc']],
                "language": {
            }
            });
        });
    
    </script>
    
@endsection

@push('scripts')
    <script src="{{ asset('js/custom.js') }}"></script> <!-- Assuming custom.js is your JavaScript file -->
@endpush
