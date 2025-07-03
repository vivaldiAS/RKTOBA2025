@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Profil Pengguna</h3><!-- End .card-title -->
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td> : </td>
                            <td>{{$profile->name}}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td> : </td>
                            <td>
                                @if($profile->gender == "L")
                                    Laki-laki
                                @elseif($profile->gender == "P")
                                    Perempuan
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td> : </td>
                            <td>{{$profile->birthday}}</td>
                        </tr>
                        <tr>
                            <td>Nomor Handphone</td>
                            <td> : </td>
                            <td>{{$profile->no_hp}}</td>
                        </tr>
                    </table>
                    <a href="./edit_profil">Edit <i class="icon-edit"></i></a></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Profil Akun</h3><!-- End .card-title -->
                    <table>
                        <tr>
                            <td>Username</td>
                            <td> : </td>
                            <td>{{$profile->username}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> : </td>
                            <td>{{$profile->email}}</td>
                        </tr>
                        @if(Session::has('alert1'))
                        <tr>
                            <td colspan="3"><a style="color:green; font-size:12.5px">{{Session::get('alert1')}}</a></td>
                        </tr>
                        @endif
                        @if(Session::has('alert2'))
                        <tr>
                            <td colspan="3"><a style="color:red; font-size:12.5px">{{Session::get('alert2')}}</a></td>
                        </tr>
                        @endif
                        <tr>
                            <td>Password</td>
                            <td> : </td>
                            <td>
                                <a href="#edit_password" class="btn btn-outline-dark btn-rounded" data-toggle="modal" href="" style="padding:5px; font-size:12.5px">
                                    <span>EDIT</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
</div><!-- .End .tab-pane -->
<div class="modal fade" id="edit_password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="tab-content" id="tab-content-5">
                        <div class="tab-pane fade show active">
                            <form action="./PostEditPassword" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group">
                                    <label for="password_sekarang">Password Sekarang *</label>
                                    <input type="password" class="form-control" id="password_sekarang" name="password_sekarang" placeholder="Masukkan password sekarang." required>
                                </div>
                                <div class="form-group">
                                    <label for="password_baru">Password Baru *</label>
                                    <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Masukkan password baru." required>
                                </div>
                                <button class="btn btn-outline-primary-2 btn-round" data-dismiss="modal" aria-label="Close">
                                    <span>TIDAK</span>
                                </button>
                                <button type="submit" class="btn btn-primary btn-round" style="float:right">
                                    <span>KONFIRMASI</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

