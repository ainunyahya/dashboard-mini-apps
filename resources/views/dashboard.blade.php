@extends('layouts.master')

@section('content')

<div class="form-group">
    <div class="row mb-3">
        <div class="col-12 col-md-4">
            <label for="yearFilter">Tahun:</label>
            <select id="yearFilter" class="form-control">
                <!-- Isi opsi tahun sesuai kebutuhan -->
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label for="startMonthFilter">Bulan Awal:</label>
            <select id="startMonthFilter" class="form-control">
                <!-- Isi opsi bulan sesuai kebutuhan -->
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label for="endMonthFilter">Bulan Akhir:</label>
            <select id="endMonthFilter" class="form-control">
                <!-- Isi opsi bulan sesuai kebutuhan -->
            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row mb-1">
        <div class="col-12 col-md-4">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <p class="card-text" id="totalPendapatan"></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Total Pembelian</h5>
                    <p class="card-text" id="totalPembelian"></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Total Komisi</h5>
                    <p class="card-text" id="totalKomisi"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" style="padding-left: 27%">
    <div class="row mb-1">
        <div class="col-12 col-md-4">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Total Piutang</h5>
                    <p class="card-text" id="totalPiutang"></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card" style="border-radius: 10px;">
                <div class="card-body">
                    <h5 class="card-title">Total Hutang</h5>
                    <p class="card-text" id="totalHutang"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-body p-4 mb-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6>Grafik ITsFood & ITsMine </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line" class="chart-canvas"></canvas>
    </div>
</div>

<div class="card-body p-4 mb-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6>Grafik ITsFood & ITsMine </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line3" class="chart-canvas"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script>
    var chartData = {!! json_encode($result) !!};
    var chartData3 = {!! json_encode($result3) !!}; // Mengonversi array ke JSON

    $(function() {
        // Inisialisasi dropdown tahun
        var years = [...new Set(chartData.map(data => moment(data.bulan_tahun, 'YYYY-MM').year()))];
        $("#yearFilter").append("<option value=''>-- Pilih Tahun --</option>");
        years.forEach(function(year) {
            $("#yearFilter").append("<option value='" + year + "'>" + year + "</option>");
        });

        // Inisialisasi dropdown bulan
        var months = moment.months();
        $("#startMonthFilter, #endMonthFilter").append("<option value=''>-- Pilih Bulan --</option>");
        months.forEach(function(month, index) {
            $("#startMonthFilter, #endMonthFilter").append("<option value='" + (index + 1) + "'>" + month + "</option>");
        });

        // Set default value untuk dropdown tahun dan bulan
        $("#yearFilter").val(moment().year());
        $("#startMonthFilter, #endMonthFilter").val(moment().month() + 1);

        // Event handler ketika nilai dropdown berubah
        $("#yearFilter, #startMonthFilter, #endMonthFilter").on("change", function() {
            updateChartFilters();
            updateChartFilters2(); 
            updateTotalPendapatan();
        });

        // Inisialisasi chart
        updateChartFilters();
        updateChartFilters2(); 
        updateTotalPendapatan();
    });

    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return "Rp " + ribuan.replace(/^0+/, '') + ",00";
    }

    function updateTotalPendapatan() {
    var selectedYear = $("#yearFilter").val();
    var startMonth = $("#startMonthFilter").val();
    var endMonth = $("#endMonthFilter").val();

    var filteredData = chartData.filter(function(data) {
        var dataDate = moment(data.bulan_tahun, 'YYYY-MM');
        var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
        var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

        return isYearMatch && isMonthRangeMatch;
    });

    var totalPendapatan = filteredData.reduce(function(sum, data) {
        return sum + parseFloat(data.total_pendapatan);
    }, 0);

    var totalPembelian = filteredData.reduce(function(sum, data) {
        return sum + parseFloat(data.total_pembelian);
    }, 0);

    var totalKomisi = filteredData.reduce(function(sum, data) {
        return sum + parseFloat(data.total_komisi);
    }, 0);

    var totalPiutang = filteredData.reduce(function(sum, data) {
        return sum + parseFloat(data.total_piutang); 
    }, 0);
    
    var totalHutang = filteredData.reduce(function(sum, data) {
        return sum + parseFloat(data.total_hutang); 
    }, 0);

    $("#totalPendapatan").text(formatRupiah(totalPendapatan));
    $("#totalPembelian").text(formatRupiah(totalPembelian));
    $("#totalKomisi").text(formatRupiah(totalKomisi));
    $("#totalPiutang").text(formatRupiah(totalPiutang));
    $("#totalHutang").text(formatRupiah(totalHutang));
}

    function updateChartFilters() {
    var selectedYear = $("#yearFilter").val();
    var startMonth = $("#startMonthFilter").val();
    var endMonth = $("#endMonthFilter").val();

    var filteredData = chartData.filter(function(data) {
        var dataDate = moment(data.bulan_tahun, 'YYYY-MM').startOf('month');
        var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
        var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

        return isYearMatch && isMonthRangeMatch;
    });
        // Debugging: Log filteredData to console
        console.log('Filtered Data (Chart 1):', filteredData);


        myLineChart.data.labels = filteredData.map(data => data.bulan_tahun);
        myLineChart.data.datasets[0].data = filteredData.map(data => data.total_pendapatan);
        myLineChart.data.datasets[1].data = filteredData.map(data => data.total_pembelian);
        myLineChart.data.datasets[2].data = filteredData.map(data => data.total_komisi);

    myLineChart.update();
    }

    function updateChartFilters2() {
        var selectedYear = $("#yearFilter").val();
        var startMonth = $("#startMonthFilter").val();
        var endMonth = $("#endMonthFilter").val();

        var filteredData = chartData3.filter(function(data) {
            var dataDate = moment(data.bulan_tahun, 'YYYY-MM');
            var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
            var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

            return isYearMatch && isMonthRangeMatch;
        });

        // Debugging: Log filteredData to console
        console.log('Filtered Data (Chart 2):', filteredData);

        myLineChart3.data.labels = filteredData.map(data => data.bulan_tahun);
        myLineChart3.data.datasets[0].data = filteredData.map(data => data.total_biaya_tambahan);
        myLineChart3.data.datasets[1].data = filteredData.map(data => data.total_diskon);

        myLineChart3.update();
    }

    //chart 1
    var ctxLine = document.getElementById('chart-line').getContext('2d');
    var myLineChart = new Chart(ctxLine, {
        type: 'bar',
        data: {
            labels: chartData.map(data => data.bulan_tahun),
            datasets: [
                {
                    label: 'Pendapatan',
                    data: chartData.map(data => data.total_pendapatan),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pembelian',
                    data: chartData.map(data => data.total_pembelian),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Komisi',
                    data: chartData.map(data => data.total_komisi),
                    backgroundColor: 'rgba(255, 205, 86, 0.2)',
                    borderColor: 'rgba(255, 205, 86, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    //chart 2
    var ctxLine3 = document.getElementById('chart-line3').getContext('2d');
    var myLineChart3 = new Chart(ctxLine3, {
        type: 'bar',
        data: {
            labels: chartData.map(data => data.bulan_tahun),
            datasets: [
                {
                    label: "Extra Cost",
                    tension: 0.4,
                    backgroundColor: 'rgba(240,198,168)',
                    borderColor: 'rgba(252,224,199)',
                    borderWidth: 1,
                    data: chartData3.map(data => data.total_biaya_tambahan),
                    maxBarThickness: 6
                },
                {
                    label: "Vendor Discount",
                    tension: 0.4,
                    backgroundColor: 'rgba(163,191,235)',
                    borderColor: 'rgba(187,209,243)',
                    borderWidth: 1,
                    data: chartData3.map(data => data.total_diskon),
                    maxBarThickness: 6
                }  
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
