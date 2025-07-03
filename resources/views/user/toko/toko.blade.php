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
                    <h3 class="card-title">Profil Toko</h3><!-- End .card-title -->
                    <table width="100%">
                        <tr>
                            <td>Nama Toko</td>
                            <td> : </td>
                            <td>{{$merchants->nama_merchant}}</td>
                        </tr>
                        <tr>
                            <td>Deskripsi Toko</td>
                            <td> : </td>
                            <td>{{$merchants->deskripsi_toko}}</td>
                        </tr>
                        <tr>
                            <td>Kontak Toko</td>
                            <td> : </td>
                            <td>{{$merchants->kontak_toko}}</td>
                        </tr>
                    </table>
                    <a href="./edit_toko">Edit <i class="icon-edit"></i></a></p>

                    <center>
                        <a href="./libur_toko" class="btn btn-primary btn-round">
                            @if($merchants->on_vacation == null)
                                Liburkan Toko
                            @elseif($merchants->on_vacation == 1)
                                Buka Toko   
                            @endif
                        </a>
                    </center>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->

        </div><!-- End .col-lg-6 -->
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <img src="./asset/u_file/foto_merchant/{{$merchants->foto_merchant}}" alt="{{$merchants->nama_merchant}}" class="product-image">
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

