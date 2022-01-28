@extends('layout.dashboard')

@section('content')
    <main class="container-fluid">
        <div class="row mt-3">
            <div class="col-6">
                <h1 class="h2 mt-4 mb-3">Penjualan bulan January</h1>
                <div id="penjualanBulanIni"></div>
            </div>
            <div class="col-6">
                <h1 class="h2 mt-4 mb-3">Persentase Kategori Barang</h1>
                <div id="persentaseKategori"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <h1 class="h2 mt-4 mb-3">10 Penjualan Terakhir</h1>
                <table class="table table-striped table-light" id="dataPenjualan10">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Customer</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tanggal Penjualan</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row" colspan="4" class="text-center">loading...</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-7">
                <h1 class="h2 mt-4 mb-3">Detail penjualan <span id="detailPenjualanHeader" class="h5"></span> </h1>
                <table class="table table-striped table-light" id="detailPenjualan">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">kode_barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">jumlah</th>
                        <th scope="col">harga satuan</th>
                        <th scope="col">harga total</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row" colspan="7" class="text-center">Pilih data penjualan di tabel sebelah kiri terlebih dahulu</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>

<script>
am5.ready(function() {

    function barChart(config = {root: 'penjualanBulanIni'}) {

        let { root }= config;
        // Create root element
        root = am5.Root.new(root);
        
        // Set themes
        root.setThemes([
        am5themes_Animated.new(root)
        ]);

        var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX"
        }));

        // Set up data source

        // Add cursor
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);


        // Create axes
        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
        xRenderer.labels.template.setAll({
        //rotation: -90,
        centerY: am5.p50,
        centerX: am5.p50,
        //paddingLeft: 2
        });

        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        maxDeviation: 0.3,
        categoryField: "tgl",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root, {})
        }));


        // Create series
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "total",
        sequencedInterpolation: true,
        categoryXField: "tgl",
        tooltip: am5.Tooltip.new(root, {
            labelText:"{valueY}"
        })
        }));

        series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
        series.columns.template.adapters.add("fill", (fill, target) => {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", (stroke, target) => {
        return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        let date = new Date();
        $.ajax({
            url: "/api/penjualan/grafik-bulan/"+(date.getMonth()+1),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                xAxis.data.setAll(data);
                series.data.setAll(data);

                // Add scrollbar
                chart.set("scrollbarX", am5.Scrollbar.new(root, {
                orientation: "horizontal"
                }));

                series.appear(1000);
                chart.appear(1000, 100);
            }
        });

    } // end barchart
    barChart();


    async function pieChart(config = {root: 'persentaseKategori'}){
        $.ajax({
            url: '{{ route('barang.kategori.persentase') }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let { root }= config;

                // create route
                root = am5.Root.new(root);
                
                // Create root and chart
                var chart = root.container.children.push( 
                    am5percent.PieChart.new(root, {
                        layout: root.verticalHorizontal
                    })
                );
                
                // Create series
                var series = chart.series.push(
                    am5percent.PieSeries.new(root, {
                        name: "Series",
                        valueField: "total",
                        categoryField: "kategori"
                    })
                );
                
                series.data.setAll(data);
            }
        });
    }

    pieChart();

}); // end am5.ready()

function loadPenjualan10() {
    $.ajax({
      url: '{{ route('penjualan.list') }}'+'?limit=10',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        let template = '';
        data.forEach((item, index) => {
          template += `
            <tr>
              <th scope="row">${index + 1}</th>
              <td>${item.nama_konsumen}</td>
              <td>${item.alamat}</td>
              <td><a href="javascript:;" onclick="loadDetailPenjualan({id: ${item.id}, name: '${item.nama_konsumen}', tanggal: '${item.tanggal_penjualan}'})">${item.tanggal_penjualan}</td>
            </tr>
          `;
        });

        $('#dataPenjualan10 tbody').html(template);
      }
    });
}

function loadDetailPenjualan(config = {id : 0, name: '', tanggal: ''}) {
    let { id, name, tanggal } = config;
    $.ajax({
      url: '/api/penjualan/' + id,
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        let template = '';
        data.forEach((item, index) => {
          template += `
            <tr>
              <th scope="row">${index+1}</th>
              <th>${item.kode_barang.toUpperCase()}</th>
              <td>${item.nama_barang}</td>
              <td>${item.kategori}</td>
              <td>${item.jumlah}</td>
              <td>Rp ${item.harga_satuan.toLocaleString()}</td>
              <td>Rp ${item.harga_total.toLocaleString()}</td>
            </tr>
          `;
        });
        
        $('#detailPenjualan tbody').html(template);
        $('#detailPenjualanHeader').html(`: ${name.toUpperCase()} - ${tanggal} (${id})`);
      }
    });
  }


$(() => {
    loadPenjualan10();
});
</script>

@endsection