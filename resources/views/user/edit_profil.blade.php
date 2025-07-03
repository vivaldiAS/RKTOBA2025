@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
<form action="./PostEditProfil" method="post" enctype="multipart/form-data">
    @csrf
        <label>Nama *</label>
        <input type="text" name="name" class="form-control" value="{{$profile->name}}" required>

        <label for="gender">Jenis Kelamin</label>
        <select class="form-control" id="gender" name="gender" required>
            @if($profile->gender == "L")
                <option value="L" selected>Laki Laki</option>
                <option value="P">Perempuan</option>
                
            @elseif($profile->gender == "P")
                <option value="L">Laki Laki</option>
                <option value="P" selected>Perempuan</option>

            @endif
        </select>
        
        <label>Tanggal Lahir</label>
        <input type="date" class="form-control" id="birthday" name="birthday" value="{{$profile->birthday}}" max="<?php echo date('Y-m-d')?>" required>
        
        <label>Nomor Handphone *</label>
        <input type="text" name="no_hp" class="form-control" value="{{$profile->no_hp}}" onkeypress="return hanyaAngka(event)" required>
        
        <script>
            function hanyaAngka(event) {
                var angka = (event.which) ? event.which : event.keyCode
                if ((angka < 48 || angka > 57) )
                    return false;
                return true;
            }
        </script>

        <button type="submit" class="btn btn-primary btn-round">
            <span>EDIT</span>
        </button>
    </form>
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

