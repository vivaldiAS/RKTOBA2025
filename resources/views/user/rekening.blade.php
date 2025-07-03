@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <form action="./PostRekening" method="post" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-sm-6">
                <label>Nama Bank *</label>
                <select name="nama_bank" class="custom-select form-control" required>
                    <option selected disabled value="">Nama Bank</option>
                    @foreach($banks as $banks)
                        <option value="{{$banks->nama_bank}}">{{$banks->nama_bank}}</option>
                    @endforeach
                </select>
                <small class="form-text">Pastikan data yang anda pilih benar.</small>
            </div><!-- End .col-sm-6 -->

            <div class="col-sm-6">
                <label>No Rekening *</label>
                <input type="text" name="nomor_rekening" class="form-control" onkeypress="return hanyaAngka(event)" required>
                <small class="form-text">Pastikan data yang anda masukkan benar.</small>
            </div><!-- End .col-sm-6 -->
            
            <script>
                function hanyaAngka(event) {
                    var angka = (event.which) ? event.which : event.keyCode
                    if ((angka < 48 || angka > 57) )
                        return false;
                    return true;
                }
            </script>
        </div><!-- End .row -->

        <label>Atas Nama *</label>
        <input type="text" name="atas_nama" class="form-control" required>
        <small class="form-text">Pastikan data yang anda masukkan benar.</small>

        <button type="submit" class="btn btn-primary btn-round">
            <span>KIRIM</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

