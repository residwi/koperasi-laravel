@extends('adminlte.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Koperasi</h3>
        <div class="form-group float-right">
            {{-- <label>Tahun</label> --}}
            @if (auth()->user()->is_admin)
            <select class="form-control" id="dropdownYear">
            </select>
            @endif
        </div>
    </div>
    <div class="card-body">
        @if (auth()->user()->is_admin)
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        @else
        SELAMAT DATANG DI APLIKASI KOPERASI PEGAWAI SAMUDERA INDONESIA (KPSI)
        @endif
    </div>
</div>
@endsection
@push('js')
{{-- <script src="{{ asset('assets/dist/js/jquery.canvasjs.min.js') }}"></script> --}}
<script src="{{ asset('assets/dist/js/canvasjs.min.js') }}"></script>
<script>
    $('document').ready(function(){
        var renderChart = function (tahun) {
            if (typeof tahun === 'undefined') {
                var tahun = (new Date()).getFullYear();
            }

            $.getJSON(`/api/laporan?tahun=${tahun}`, function(data) {
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    // theme: 'light2',
                    title:{
                        text: `Laporan Koperasi Tahun ${tahun}`
                    },
                    toolTip: {
                        shared: true
                    },
                    axisY: {
                        title: "Total Dana",
                        titleFontColor: "#4F81BC",
                        valueFormatString: "#,###",
                    },
                    data: [{
                        type: "splineArea", 
                        showInLegend: true,
                        name: "Total Dana Simpanan",
                        dataPoints: data.simpanan
                    },
                    {
                        type: "splineArea", 
                        showInLegend: true,
                        name: "Total Dana Pinjaman",
                        dataPoints: data.pinjaman
                    }]
                });
                chart.render();
            });
        }

        renderChart();

        $('#dropdownYear').each(function() {
            var year = (new Date()).getFullYear();
            var current = year;
            for (var i = 0; i < 5; i++) {
            if ((year+i) == current)
                $(this).append('<option selected value="' + (year + i) + '">' + (year + i) + '</option>');
            else
                $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
            }
        })

        $("#dropdownYear").on('change', function() {
            renderChart($(this).val());
        });

        
    })
</script>
@endpush