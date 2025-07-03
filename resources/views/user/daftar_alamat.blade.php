@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <a class="nav-link btn btn-outline-primary-2" href="./alamat">
        <span>TAMBAH ALAMAT</span>
        <i class="icon-long-arrow-right"></i>
    </a>
    <div class="mb-2"></div>
    <div class="row">
    @foreach($user_address as $user_address)
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Alamat {{$loop->iteration}}</h3><!-- End .card-title -->
                    <p>{{$user_address->province_name}}<br>
                    {{$user_address->city_name}}<br>
                    {{$user_address->subdistrict_name}}<br>
                    {{$user_address->user_street_address}}<br>
                    <a href="./hapus_alamat/{{$user_address->user_address_id}}">Hapus</a></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    @endforeach
    </div><!-- End .row -->
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

