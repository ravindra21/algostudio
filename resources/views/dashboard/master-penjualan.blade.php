@extends('layout.dashboard')

@section('content')
    <main class="container-fluid">
        <div class="row">
            <div class="col-5">
                <h1 class="h2 mt-4 mb-3">Table Penjualan</h1>
                <table class="table table-striped table-light" id="dataPenjualan">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Nama Konsumen</th>
                        <th scope="col">Alamat</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row" colspan="4" class="text-center">Loading...</th>
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
<script>
  function loadPenjualan() {
    $.ajax({
      url: '{{ route('penjualan.list') }}',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        let template = '';
        data.forEach((item, index) => {
          template += `
            <tr>
              <th scope="row">${index + 1}</th>
              <td><a href="javascript:;" onclick="loadDetailPenjualan({id: ${item.id}, name: '${item.nama_konsumen}', tanggal: '${item.tanggal_penjualan}'})">${item.tanggal_penjualan}</a></td>
              <td>${item.nama_konsumen}</td>
              <td>${item.alamat}</td>
            </tr>
          `;
        });
        
        $('#dataPenjualan tbody').html(template);
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
    loadPenjualan();
  });
</script>

@endsection