@extends('layouts.master')

@section('content')

<div class="form-group">
    <div class="row mb-3">
        <div class="col-12 col-md-4">
            <h6 for="yearFilter" style="font-family: 'Poppins Medium'; color: #000000;">Tahun:</h6>
            <select id="yearFilter" class="form-control">
                <!-- Isi opsi tahun sesuai kebutuhan -->
            </select>
        </div>
        <div class="col-12 col-md-4">
            <h6 for="startMonthFilter" style="font-family: 'Poppins Medium'; color: #000000;">Bulan Awal:</h6>
            <select id="startMonthFilter" class="form-control">
                <!-- Isi opsi bulan sesuai kebutuhan -->
            </select>
        </div>
        <div class="col-12 col-md-4">
            <h6 for="endMonthFilter" style="font-family: 'Poppins Medium'; color: #000000;">Bulan Akhir:</h6>
            <select id="endMonthFilter" class="form-control">
                <!-- Isi opsi bulan sesuai kebutuhan -->
            </select>
        </div>
    </div>
</div>

<div class="card-body mb-4 p-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6 style="font-family: 'Poppins Medium';"> Grafik ITsFood & ITsMine </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line" class="chart-canvas"></canvas>
    </div>
</div>

<div class="card-body p-4 mb-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6 style="font-family: 'Poppins Medium';">Grafik ITsFood </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line1" class="chart-canvas"></canvas>
    </div>
</div>

<div class="card-body p-4 mb-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6 style="font-family: 'Poppins Medium';">Grafik ITsMine </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line2" class="chart-canvas"></canvas>
    </div>
</div>

<div class="card-body p-4 mb-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6 style="font-family: 'Poppins Medium';">Grafik ITsFood & ITsMine </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line3" class="chart-canvas"></canvas>
    </div>
</div>

<div class="card-body p-4 mb-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6 style="font-family: 'Poppins Medium';">Grafik ITsFood </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line4" class="chart-canvas"></canvas>
    </div>
</div>

<div class="card-body p-4 mb-4 bg-white" style="width: 100%;  border-radius: 10px;">
    <div class="d-flex align-items-baseline">
        <i class="fas fa-database m-2"></i> <!-- Ganti "fa-icon-name" dengan kelas ikon yang sesuai -->
        <h6 style="font-family: 'Poppins Medium';">Grafik ITsMine </h6>
    </div>
    <div class="chart">
        <canvas id="chart-line5" class="chart-canvas"></canvas>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script>
    var chartData = {!! json_encode($result) !!}; // Mengonversi array ke JSON
    var chartData1 = {!! json_encode($result1) !!}; // Mengonversi array ke JSON
    var chartData2 = {!! json_encode($result2) !!}; // Mengonversi array ke JSON
    var chartData3 = {!! json_encode($result3) !!}; // Mengonversi array ke JSON
    var chartData4 = {!! json_encode($result4) !!}; // Mengonversi array ke JSON
    var chartData5 = {!! json_encode($result5) !!}; // Mengonversi array ke JSON

    $(function() {
        var years = [...new Set(chartData.map(data => moment(data.bulan_tahun, 'YYYY-MM').year()))];
        $("#yearFilter").append("<option value=''>-- Pilih Tahun --</option>");
        years.forEach(function(year) {
            $("#yearFilter").append("<option value='" + year + "'>" + year + "</option>");
        });

        var months = moment.months();
        $("#startMonthFilter, #endMonthFilter").append("<option value=''>-- Pilih Bulan --</option>");
        months.forEach(function(month, index) {
            $("#startMonthFilter, #endMonthFilter").append("<option value='" + (index + 1) + "'>" + month + "</option>");
        });

        $("#yearFilter").val(moment().year());
        $("#startMonthFilter, #endMonthFilter").val(moment().month() + 1);

        $("#yearFilter, #startMonthFilter, #endMonthFilter").on("change", function() {
            updateChartFilters();
            updateChartFilters1();
            updateChartFilters2();
            updateChartFilters3();
            updateChartFilters4();
            updateChartFilters5();
        });

        // Inisialisasi chart
        updateChartFilters();
            updateChartFilters1();
            updateChartFilters2();
            updateChartFilters3();
            updateChartFilters4();
            updateChartFilters5();
    });

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

    myLineChart.data.labels = filteredData.map(data => data.bulan_tahun);
    myLineChart.data.datasets[0].data = filteredData.map(data => data.total_pendapatan);
    myLineChart.data.datasets[1].data = filteredData.map(data => data.total_pembelian);
    myLineChart.data.datasets[2].data = filteredData.map(data => data.total_komisi);

    myLineChart.update();
    }

    function updateChartFilters1() {
        var selectedYear = $("#yearFilter").val();
        var startMonth = $("#startMonthFilter").val();
        var endMonth = $("#endMonthFilter").val();

        var filteredData = chartData1.filter(function(data) {
            var dataDate = moment(data.bulan_tahun, 'YYYY-MM');
            var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
            var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

            return isYearMatch && isMonthRangeMatch;
        });

        myLineChart1.data.labels = filteredData.map(data => data.bulan_tahun);
        myLineChart1.data.datasets[0].data = filteredData.map(data => data.total_pendapatan);
        myLineChart1.data.datasets[1].data = filteredData.map(data => data.total_pembelian);
        myLineChart1.data.datasets[2].data = filteredData.map(data => data.total_komisi);

        myLineChart1.update();
    }

    function updateChartFilters2() {
        var selectedYear = $("#yearFilter").val();
        var startMonth = $("#startMonthFilter").val();
        var endMonth = $("#endMonthFilter").val();

        var filteredData = chartData2.filter(function(data) {
            var dataDate = moment(data.bulan_tahun, 'YYYY-MM');
            var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
            var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

            return isYearMatch && isMonthRangeMatch;
        });

        myLineChart2.data.labels = filteredData.map(data => data.bulan_tahun);
        myLineChart2.data.datasets[0].data = filteredData.map(data => data.total_pendapatan);
        myLineChart2.data.datasets[1].data = filteredData.map(data => data.total_pembelian);
        myLineChart2.data.datasets[2].data = filteredData.map(data => data.total_komisi);

        myLineChart2.update();
    }

    function updateChartFilters3() {
        var selectedYear = $("#yearFilter").val();
        var startMonth = $("#startMonthFilter").val();
        var endMonth = $("#endMonthFilter").val();

        var filteredData = chartData3.filter(function(data) {
            var dataDate = moment(data.bulan_tahun, 'YYYY-MM');
            var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
            var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

            return isYearMatch && isMonthRangeMatch;
        });

        myLineChart3.data.labels = filteredData.map(data => data.bulan_tahun);
        myLineChart3.data.datasets[0].data = filteredData.map(data => data.total_biaya_tambahan);
        myLineChart3.data.datasets[1].data = filteredData.map(data => data.total_diskon);

        myLineChart3.update();
    }

    function updateChartFilters4() {
        var selectedYear = $("#yearFilter").val();
        var startMonth = $("#startMonthFilter").val();
        var endMonth = $("#endMonthFilter").val();

        var filteredData = chartData4.filter(function(data) {
            var dataDate = moment(data.bulan_tahun, 'YYYY-MM');
            var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
            var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

            return isYearMatch && isMonthRangeMatch;
        });

        myLineChart4.data.labels = filteredData.map(data => data.bulan_tahun);
        myLineChart4.data.datasets[0].data = filteredData.map(data => data.total_biaya_tambahan);
        myLineChart4.data.datasets[1].data = filteredData.map(data => data.total_diskon);

        myLineChart4.update();
    }

    function updateChartFilters5() {
        var selectedYear = $("#yearFilter").val();
        var startMonth = $("#startMonthFilter").val();
        var endMonth = $("#endMonthFilter").val();

        var filteredData = chartData5.filter(function(data) {
            var dataDate = moment(data.bulan_tahun, 'YYYY-MM');
            var isYearMatch = selectedYear === '' || dataDate.year() == selectedYear;
            var isMonthRangeMatch = startMonth === '' || endMonth === '' || (dataDate.month() + 1 >= startMonth && dataDate.month() + 1 <= endMonth);

            return isYearMatch && isMonthRangeMatch;
        });

        myLineChart5.data.labels = filteredData.map(data => data.bulan_tahun);
        myLineChart5.data.datasets[0].data = filteredData.map(data => data.total_biaya_tambahan);
        myLineChart5.data.datasets[1].data = filteredData.map(data => data.total_diskon);

        myLineChart5.update();
    }

    // Chart 1 Line
    var ctxLine = document.getElementById('chart-line').getContext('2d');
    var myLineChart = new Chart(ctxLine, {
        type: 'bar',
        data: {
            labels: chartData.map(data => data.bulan_tahun),
            datasets: [
                {
                    label: 'Pendapatan',
                    data: chartData.map(data => data.total_pendapatan),
                    backgroundColor: 'rgba(47, 112, 242, 0.2)',
                    borderColor: 'rgba(47, 112, 242, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pembelian',
                    data: chartData.map(data => data.total_pembelian),
                    backgroundColor: 'rgba(135, 106, 254, 0.2)',
                    borderColor: 'rgba(135, 106, 254, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Komisi',
                    data: chartData.map(data => data.total_komisi),
                    backgroundColor: 'rgba(255, 188, 2, 0.2)',
                    borderColor: 'rgba(255, 188, 2, 1)',
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

    // Chart 2 Line
    var ctxLine1 = document.getElementById('chart-line1').getContext('2d');
    var myLineChart1 = new Chart(ctxLine1, {
        type: 'bar',
        data: {
            labels: chartData1.map(data => data.bulan_tahun),
            datasets: [
                {
                    label: 'Pendapatan',
                    data: chartData1.map(data => data.total_pendapatan),
                    backgroundColor: 'rgba(47, 112, 242, 0.2)',
                    borderColor: 'rgba(47, 112, 242, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pembelian',
                    data: chartData1.map(data => data.total_pembelian),
                    backgroundColor: 'rgba(135, 106, 254, 0.2)',
                    borderColor: 'rgba(135, 106, 254, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Komisi',
                    data: chartData1.map(data => data.total_komisi),
                    backgroundColor: 'rgba(255, 188, 2, 0.2)',
                    borderColor: 'rgba(255, 188, 2, 1)',
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

    // Chart 3 Line
    var ctxLine2 = document.getElementById('chart-line2').getContext('2d');
    var myLineChart2 = new Chart(ctxLine2, {
        type: 'bar',
        data: {
            labels: chartData2.map(data => data.bulan_tahun),
            datasets: [
                {
                    label: 'Pendapatan',
                    data: chartData2.map(data => data.total_pendapatan),
                    backgroundColor: 'rgba(47, 112, 242, 0.2)',
                    borderColor: 'rgba(47, 112, 242, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pembelian',
                    data: chartData2.map(data => data.total_pembelian),
                    backgroundColor: 'rgba(135, 106, 254, 0.2)',
                    borderColor: 'rgba(135, 106, 254, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Komisi',
                    data: chartData2.map(data => data.total_komisi),
                    backgroundColor: 'rgba(255, 188, 2, 0.2)',
                    borderColor: 'rgba(255, 188, 2, 1)',
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

    // Chart 4 Line
    var ctxLine3 = document.getElementById('chart-line3').getContext('2d');
    var myLineChart3 = new Chart(ctxLine3, {
        type: 'bar',
        data: {
            labels: chartData3.map(data => data.bulan_tahun),
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

    // Chart 5 Line
    var ctxLine4 = document.getElementById('chart-line4').getContext('2d');
    var myLineChart4 = new Chart(ctxLine4, {
        type: 'bar',
        data: {
            labels: chartData4.map(data => data.bulan_tahun),
            datasets: [
                {
                    label: "Extra Cost",
                    tension: 0.4,
                    backgroundColor: 'rgba(240,198,168)',
                    borderColor: 'rgba(252,224,199)',
                    borderWidth: 1,
                    data: chartData4.map(data => data.total_biaya_tambahan),
                    maxBarThickness: 6
                },
                {
                    label: "Vendor Discount",
                    tension: 0.4,
                    backgroundColor: 'rgba(163,191,235)',
                    borderColor: 'rgba(187,209,243)',
                    borderWidth: 1,
                    data: chartData4.map(data => data.total_diskon),
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

    // Chart 6 Line
    var ctxLine5 = document.getElementById('chart-line5').getContext('2d');
    var myLineChart5 = new Chart(ctxLine5, {
        type: 'bar',
        data: {
            labels: chartData5.map(data => data.bulan_tahun),
            datasets: [
                {
                    label: "Extra Cost",
                    tension: 0.4,
                    backgroundColor: 'rgba(240,198,168)',
                    borderColor: 'rgba(252,224,199)',
                    borderWidth: 1,
                    data: chartData5.map(data => data.total_biaya_tambahan),
                    maxBarThickness: 6
                },
                {
                    label: "Vendor Discount",
                    tension: 0.4,
                    backgroundColor: 'rgba(163,191,235)',
                    borderColor: 'rgba(187,209,243)',
                    borderWidth: 1,
                    data: chartData5.map(data => data.total_diskon),
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
