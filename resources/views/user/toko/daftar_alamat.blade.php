@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Alamat Toko</h3><!-- End .card-title -->
                    <p>{{$merchant_address->province_name}}<br>
                    {{$merchant_address->city_name}}<br>
                    {{$merchant_address->subdistrict_name}}<br>
                    {{$merchant_address->merchant_street_address}}<br>
                    <a href="./hapus_alamat/{{$merchant_address->merchant_address_id}}">Hapus</a></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

