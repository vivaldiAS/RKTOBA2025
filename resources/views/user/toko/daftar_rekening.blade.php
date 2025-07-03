@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <a class="nav-link btn btn-outline-primary-2" href="./rekening">
        <span>TAMBAH REKENING</span>
        <i class="icon-long-arrow-right"></i>
    </a>
    <div class="mb-2"></div>
    <div class="row">
    @foreach($rekenings as $rekenings)
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Rekening {{$loop->iteration}}</h3><!-- End .card-title -->

                    <p>{{$rekenings->atas_nama}}<br>
                    {{$rekenings->nama_bank}}<br>
                    {{$rekenings->nomor_rekening}}<br>
                    <a href="./hapus_rekening/{{$rekenings->rekening_id}}">Hapus</a></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    @endforeach
    </div><!-- End .row -->
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

