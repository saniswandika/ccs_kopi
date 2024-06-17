@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Perhitungan'])
    <div class="container-fluid py-4">
      
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-2">Nilai Awal</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive-md btn-table">
                            <tr>
                                <th>No</th>
                                <th>Biji Kopi</th>
                                @foreach ($kriterias as $kriteria)
                                    <th>{{ $kriteria->kriteria }} ({{ $kriteria->tipe }})</th>
                                @endforeach
                            </tr>
                            @foreach ($bijikopis as $bijikopi)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $bijikopi->nama }}</td>
                                    @foreach ($kriterias as $kriteria)
                                        @if ($bijikopi->nilaiKriteriaTabel1($kriteria))
                                            <td>{{ $bijikopi->nilaiKriteriaTabel1($kriteria) }}</td>
                                        @else
                                            <td style="color: red">
                                                <b>Belum Diisi</b>
                                                <i class="fas fa-exclamation-circle"></i>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-2">Nilai Cost Benefit</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive-md btn-table">
                            <tr>
                                <th>No</th>
                                <th>Biji Kopi</th>
                                @foreach ($kriterias as $kriteria)
                                    <th>{{ $kriteria->kriteria }} ({{ $kriteria->tipe }})</th>
                                @endforeach
                            </tr>
                            @foreach ($bijikopis as $bijikopi)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $bijikopi->nama }}</td>
                                    @foreach ($kriterias as $kriteria)
                                        @if ($bijikopi->nilaiKriteriaTabel2($kriteria))
                                            <td>{{ $bijikopi->nilaiKriteriaTabel2($kriteria) }}</td>
                                        @else
                                            <td style="color: red">
                                                <b>Belum Diisi</b>
                                                <i class="fas fa-exclamation-circle"></i>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-2">Nilai Dikali dengan Bobot</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive-md btn-table">
                            <tr>
                                <th>No</th>
                                <th>Biji Kopi</th>
                                @foreach ($kriterias as $kriteria)
                                    <th>{{ $kriteria->kriteria }} ({{ $kriteria->tipe }})</th>
                                @endforeach
                            </tr>
                            @foreach ($bijikopis as $bijikopi)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $bijikopi->nama }}</td>
                                    @foreach ($kriterias as $kriteria)
                                        @if ($bijikopi->nilaiKriteriaTabel3($kriteria))
                                            <td>{{ $bijikopi->nilaiKriteriaTabel3($kriteria) }}</td>
                                        @else
                                            <td style="color: red">
                                                <b>Belum Diisi</b>
                                                <i class="fas fa-exclamation-circle"></i>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-2">Nilai dan Peringkat Akhir Kopi</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive-md btn-table">
                            <tr>
                                <th>No</th>
                                <th>Biji Kopi</th>
                                @foreach ($kriterias as $kriteria)
                                    <th>{{ $kriteria->kriteria }} ({{ $kriteria->tipe }})</th>
                                @endforeach
                                <th>Total</th>
                                <th>Ranking</th>
                            </tr>
                            @foreach ($bijiKopiCollection as $index => $bijikopi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bijikopi['bijikopi']->nama }}</td>
                                    @foreach ($kriterias as $kriteria)
                                        @if ($bijikopi['bijikopi']->nilaiKriteriaTabel3($kriteria))
                                            <td>{{ $bijikopi['bijikopi']->nilaiKriteriaTabel3($kriteria) }}</td>
                                        @else
                                            <td style="color: red">
                                                <b>Belum Diisi</b>
                                                <i class="fas fa-exclamation-circle"></i>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td>{{ $bijikopi['score'] }}</td>
                                    <td>{{ $index + 1 }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="{{ count($kriterias) + 3 }}"><strong>Ideal: {{ $ideal->nama }} (Skor: {{ $bijiKopiCollection[0]['score'] }})</strong></td>
                            </tr>
                            <tr>
                                <td colspan="{{ count($kriterias) + 3 }}"><strong>Inti-Ideal: {{ $intiIdeal->nama }} (Skor: {{ $bijiKopiCollection[count($bijiKopiCollection) - 1]['score'] }})</strong></td>
                            </tr>
                        </table>
                        <div class="alert alert-primary" role="alert">
                            Kesimpulan: Dari hasil perhitungan yang dilakukan menggunakan metode CoCoSo, Biji Kopi Terbaik untuk dipilih adalah {{ $numberOne->nama }} dengan nilai {{ $bijiKopiCollection[0]['score'] }}.
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endpush
