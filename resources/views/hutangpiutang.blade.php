@extends('layouts.master')

@section('content')

<div class="mb-3">
    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px  solid #ccc; width: 100%">
        <i class="fas fa-calendar"></i>&nbsp;
        <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block; max-width: 80%;"></span><b class="caret"></b>
    </div>
</div>

<div class="form-group">
    <div class="row mb-1">
        <div class="card-body p-4 ml-2 bg-white" style="width: 45%;  border-radius: 10px;">
            <div class="d-flex align-items-baseline">
                <i class="fas fa-database m-2"></i>
                <h6 style="font-family: 'Poppins Medium';">Piutang</h6>
            </div>
            <div class="chart">
                <canvas id="chart-line-1" class="chart-canvas"></canvas>
            </div>
        </div>
        <div class="card-body p-4 ml-4 mr-2 bg-white" style="width: 45%;  border-radius: 10px;">
        <div class="d-flex align-items-baseline">
            <i class="fas fa-database m-2"></i>
            <h6 style="font-family: 'Poppins Medium';">Hutang</h6>
        </div>
        <div class="chart">
            <canvas id="chart-line-2" class="chart-canvas"></canvas>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row mb-1">
        <div class="card-body p-4 ml-2 bg-white" style="width: 45%;  border-radius: 10px;">
            <div class="d-flex align-items-baseline ">
                <i class="fas fa-database m-2 pb-2"></i>
                <h6 style="font-family: 'Poppins Medium';">Unit dengan hutang tertinggi</h6>
            </div>
            <div >
                <table class="table table-striped">
                    <thead style="padding-bottom: 2px">
                        <tr>
                            <th scope="col" >No</th>
                            <th scope="col">Nama Unit</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (json_decode($chartData1) as $index => $data)
                            <tr>
                                <th style="font-size: 14px;" scope="row">{{ $index + 1 }}</th>
                                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding: 5px; max-width: 250px; font-size: 14px;">{{ $data->unit_name }}</td>
                                <td style="font-size: 14px;" class="justify-content-between">Rp. {{ number_format($data->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body p-4 ml-2 bg-white" style="width: 45%;  border-radius: 10px;">
            <div class="d-flex align-items-baseline">
                <i class="fas fa-database m-2 pb-2"></i>
                <h6 style="font-family: 'Poppins Medium';">Hutang ke Vendor tertinggi</h6>
            </div>
            <div>
                <table class="table table-striped">
                    <thead style="padding-bottom: 2px">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Vendor</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (json_decode($chartData2) as $index => $data)
                            <tr>
                                <th style="font-size: 14px;" scope="row">{{ $index + 1 }}</th>
                                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding: 5px; max-width: 250px; font-size: 14px;">{{ $data->nama_vendor }}</td>
                                <td style="font-size: 14px;">Rp. {{ number_format($data->total_hutang, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker"></script>

<script>
    $(document).ready(function() {
        var chartData = {!! $chartData !!};
        var originalData = chartData;

        // Inisialisasi chart pertama dengan data dan labels
        var labels1 = originalData.map(function(item) {
            return item.tanggal;
        });

        var data1 = originalData.map(function(item) {
            return item.total_qty_1; // Ganti total_qty_1 sesuai dengan kolom yang sesuai
        });

        var ctx1 = document.getElementById('chart-line-1').getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels1,
                datasets: [{
                    label: 'Piutang',
                    data: data1,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Inisialisasi chart kedua dengan data dan labels yang berbeda
        var labels2 = originalData.map(function(item) {
            return item.tanggal;
        });

        var data2 = originalData.map(function(item) {
            return item.total_qty_2; // Ganti total_qty_2 sesuai dengan kolom yang sesuai
        });

        var ctx2 = document.getElementById('chart-line-2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Hutang',
                    data: data2,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function updateChart(data, chart) {
            chart.data.datasets[0].data = data;
            chart.update();
        }

        $('#reportrange').daterangepicker({
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, labels) {
            console.log('Date Range Changed:', start.format('YYYY-MM-DD'), 'to', end.format('YYYY-MM-DD'));

            var filteredData = originalData.filter(function(item) {
                var itemDate = moment(item.tanggal, 'YYYY-MM-DD');
                return itemDate.isBetween(start, end, null, '[]');
            });

            console.log('Filtered Data:', filteredData);

            updateChart(filteredData.map(function(item) {
                return item.total_qty_1; // Ganti total_qty_1 sesuai dengan kolom yang sesuai
            }), myChart1);

            // Update chart kedua dengan data baru (ganti total_qty_2 sesuai dengan kolom yang sesuai)
            updateChart(filteredData.map(function(item) {
                return item.total_qty_2;
            }), myChart2);

            // Update label rentang tanggal
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });
    });
</script>

@endsection
