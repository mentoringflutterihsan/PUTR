@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="cart-title">Grafik Pembangunan 4 Tahun Terakhir</h4>
    </div>
    <div class="card-body">
        <div id="graph-container" style="height: 400px"></div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="//cdn.amcharts.com/lib/4/core.js"></script>
    <script src="//cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="//cdn.amcharts.com/lib/4/maps.js"></script>
    <script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        am4core.useTheme(am4themes_animated);

        const loadGraph = () => {
            axios.get(base_url + '/graph/pembangunan')
                .then(res => {
                    let res_data = res.data;

                    let chart = am4core.create('graph-container', am4charts.XYChart);
                    chart.data = res_data;

                    let tglAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                    tglAxis.dataFields.category = "tahun";
                    tglAxis.title.text = "Tahun";

                    let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

                    let series = chart.series.push(new am4charts.LineSeries());
                    series.dataFields.valueY = "total";
                    series.dataFields.categoryX = "tahun";
                    series.name = "Total";
                    series.strokeWidth = 5;
                    series.strokeOpacity = 0.3;

                    let bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.strokeWidth = 2;
                    bullet.stroke = am4core.color("#fff")
                });
        }

        loadGraph();
    </script>
@endpush