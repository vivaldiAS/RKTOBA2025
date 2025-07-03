@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<style>
    .intro-slider-container,
    .intro-slide {
        height: 300px;
    }

    .experience-hero {
        background-color: #814D4D;
        height: 300px;
    }

    .img-rental {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 40%;
        height: 150px;
    }
</style>

@section('container')
<main class="main">
    <div class="experience-hero">
        <div class="col-md-12 text-center">
            <h1 class="text-white pt-5">Experience</h1>
            <p class="text-white">Dapatkan pengalaman liburan yang tak terlupakan dengan Rumah Kreatif Toba Experience</p>
            <a href="" class="btn btn-primary mt-5">Jelajahi</a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 p-5 text-center">
                <img class="img-rental" src="{{ asset('asset/rental_image/mobil1.png') }}" alt="">
                <a href="/rental" class="btn btn-primary mt-2">Rental Mobil</a>
            </div>
            <div class="col-md-6 p-5 text-center">
                <img class="img-rental" src="{{ asset('asset/museum/museum1.png') }}" alt="">
                <a href="/tiket" class="btn btn-primary mt-2">Tiket</a>
            </div>
        </div>
    </div>
</main><!-- End .main -->

@endsection