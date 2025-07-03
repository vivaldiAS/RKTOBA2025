@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <form action="./PostPengirimanLokal" method="post" enctype="multipart/form-data">
    @csrf        
        <label>Kecamatan *</label>
        <select name="subdistrict" id="subdistrict" class="custom-select form-control" required>
            <option value="" disabled selected>Pilih Kecamatan</option>
        </select>

        <label>Biaya Pengiriman *</label>
        <input type="number" name="biaya_jasa" class="form-control" placeholder="Masukkan Biaya Pengiriman"required>

        <button type="submit" class="btn btn-primary btn-round">
            <span>TAMBAH</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>    
    $city_id = <?php echo $merchant_address->city_id ?>;

    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/ambil_lokasi",
        data: "url=" + "subdistrict?city=" + $city_id,
        complete: function (data) {
            console.log(data);
            data.then((result) => {
                var _data = $.parseJSON(result);
                _data["rajaongkir"]["results"].forEach((subdistrict) => {
                    $("#subdistrict").append($('<option>', {
                        value: subdistrict["subdistrict_id"],
                        text: subdistrict["subdistrict_name"],
                    }))
                });
            })
        }
    });
</script>


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

