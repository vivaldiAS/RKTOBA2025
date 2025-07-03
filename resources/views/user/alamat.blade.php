@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <form action="./PostAlamat" method="post" enctype="multipart/form-data">
    @csrf
        @if($product)
            <input type="number" name="product" value="{{(int)$product}}" hidden>
        @endif

        <label>Provinsi *</label>
        <input type="text" name="province_name" id="province_name" style="display: none;"/>
        <select name="province" id="province" class="custom-select form-control" required>
            <option value="" disabled selected>Pilih Provinsi</option>
        </select>
        
        <label>Kabupaten/Kota *</label>
        <input type="text" name="city_name" id="city_name" style="display: none;"/>
        <select name="city" id="city" class="custom-select form-control" required>
            <option value="" disabled selected>Pilih Kabupaten/Kota</option>
        </select>
        
        <label>Kecamatan *</label>
        <input type="text" name="subdistrict_name" id="subdistrict_name" style="display: none;"/>
        <select name="subdistrict" id="subdistrict" class="custom-select form-control" required>
            <option value="" disabled selected>Pilih Kecamatan</option>
        </select>

        <label>Jalan *</label>
        <input type="text" name="street_address" class="form-control" placeholder="Masukkan Jalan Alamat"required>
        <small class="form-text">Pastikan data yang anda masukkan benar.</small>

        <button type="submit" class="btn btn-primary btn-round">
            <span>TAMBAH</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{ URL::asset('asset/js/function.js') }}"></script>


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

