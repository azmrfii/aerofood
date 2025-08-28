@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4 mb-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5>Total Uang Diluar</h5>
                    <h3>Rp {{ number_format($totalUangDiluar, 0, ',', '.') }}</h3>
                    <small>{{ $jumlahPODiluar }} PO</small>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Total Uang Masuk</h5>
                    <h3>Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</h3>
                    <small>{{ $jumlahPOMasuk }} PO</small>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Keuntungan</h5>
                    <h3>Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</h3>
                    <small>dari {{ $jumlahPO }} PO</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Pie Chart -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Total PO per Jenis Barang</h5>
                </div>
                <div class="card-body" style="height: 400px;">
                    <canvas id="poChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        const ctx = document.getElementById('poChart').getContext('2d');

        const poChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($poByBarang->pluck('nama_barang')) !!},
                datasets: [{
                    label: 'Jumlah PO',
                    data: {!! json_encode($poByBarang->pluck('total')) !!},
                    backgroundColor: [
                        '#4e79a7',
                        '#f28e2b',
                        '#e15759',
                        '#76b7b2',
                        '#59a14f',
                        '#edc948',
                        '#b07aa1',
                        '#ff9da7',
                        '#9c755f',
                        '#bab0ac'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        },
                        formatter: (value, ctx) => {
                            const label = ctx.chart.data.labels[ctx.dataIndex];
                            return label + ': ' + value + ' PO';
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const val = context.parsed;
                                const percent = ((val / total) * 100).toFixed(1);
                                return `${context.label}: ${val} PO (${percent}%)`;
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
@stop
