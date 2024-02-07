@extends('layouts.master')

@section('content')

<style>
    .dropdown-menu {
        text-align: center;
    }

    .dropdown-menu li {
        display: block;
        
    }
</style>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Pesanan</h2>
        </div>
        <a href="demo/create" class="btn btn-success">Buat</a>
    </div>
</div>
    <div class="card-body mb-4 p-4 bg-white" style="width: 100%;  border-radius: 10px;">
        <div class="table-container" style="width: 100%">
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
                                          <a class="dropdown-item" href="#" onclick="deletePesanan({{ $order->id }})">delete</a>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[0, 'desc']]
            });
        });
    
        function deletePesanan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: baseUrl + id,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        console.log(data);
                        location.reload(); // Menggunakan location.reload() untuk merefresh halaman
                    },
                    error: function (data) {
                        console.error('Error:', data);
                    }
                });
            }
        }
    </script>
    
@endsection

@push('scripts')
    <script>
        // Pass the base URL to the JavaScript file
        var baseUrl = '{{ url("demo") }}';
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script> <!-- Assuming custom.js is your JavaScript file -->
@endpush
