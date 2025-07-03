@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<style>
/* .intro-slider-container{
        width:80%;
    }
    .intro-slider-container, .intro-slide{
        height:300px;
    } */


@media screen and (min-width: 200px) {
    .intro-slider-container {
        max-height: 50px;
    }
}

@media screen and (min-width: 325px) {
    .intro-slider-container {
        max-height: 80px;
    }
}

@media screen and (min-width: 450px) {
    .intro-slider-container {
        max-height: 110px;
    }
}

@media screen and (min-width: 575px) {
    .intro-slider-container {
        max-height: 140px;
    }
}

@media screen and (min-width: 700px) {
    .intro-slider-container {
        max-height: 170px;
    }
}

@media screen and (min-width: 825px) {
    .intro-slider-container {
        max-height: 195px;
    }
}

@media screen and (min-width: 950px) {
    .intro-slider-container {
        max-height: 230px;
    }
}

@media screen and (min-width: 1075px) {
    .intro-slider-container {
        max-height: 260px;
    }
}

@media screen and (min-width: 1200px) {
    .intro-slider-container {
        max-height: 290px;
    }
}

.tiket-title {
    font-size: 16px;
}

.card-img-top {
    height: 180px;
    object-fit: cover;
}
</style>

@section('container')

<main class="main">
    <center>
        <div class="intro-slider-container" style="width:92%; height:290px">
            <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl"
                data-owl-options='{"nav": false}'>
            </div><!-- End .owl-carousel owl-simple -->
            <span class="slider-loader text-white"></span><!-- End .slider-loader -->
        </div><!-- End .intro-slider-container -->
    </center>

    <div class="container">
        <h5 class="mt-3">Pencarian Saat Ini</h5>
        <div class="row mt-3">
            <div class="card col-md-1">
                <img src="{{ asset('asset/tiket/1.png') }}" alt="" style="width: 100%;">
            </div>
            <div class="card col-md-2">
                <h6 class="mt-2">Museum Balige </h6>
                <p>32 Places</p>
            </div>

            <div class="card col-md-1">
                <img src="{{ asset('asset/tiket/2.png') }}" alt="" style="width: 100%;">
            </div>

            <div class="card col-md-2">
                <h6 class="mt-2">Museum Balige </h6>
                <p>32 Places</p>
            </div>

            <div class="col-md-1 card">
                <img src="{{ asset('asset/tiket/3.png') }}" alt="" style="width: 100%;">
            </div>
            <div class="card col-md-2">
                <h6 class="mt-2">Kolam Renang Balige</h6>
                <p>32 Places</p>
            </div>

            <div class="col-md-1 card">
                <img src="{{ asset('asset/tiket/5.png') }}" alt="" style="width: 100%;">
            </div>

            <div class="card col-md-2">
                <h6 class="mt-2">Kolam Renang Balige</h6>
                <p>32 Places</p>
            </div>

        </div>


    </div><!-- End .container -->

    <div class="mb-9"></div>

    <div class="container">
        <h5 class="">Pilihan Tiket Wisata</h5>
        <div class="row">
            <br>
            <div class="col-md-9">
                <p style="color: black;">Silahkan pilih tiket wisata sesuai dengan keinginan anda. <br>
                    Kami menyediakan tiket wisata terbaru pada masa kini</p>
            </div>
            <div class="col">
                <a href="" class="btn btn-light"> Lihat Semua</a>
            </div>
        </div>
        <div class="row mt-3">
            @foreach ($tickets as $item)
            <div class="col-md-3 card-mobil-container">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('asset/tiket/4.png') }}" alt="">
                    <div class="card-body">
                        <h6 class="tiket-title">{{ $item->nama }}</h6>
                        <p class="card-text">{{ $item->lokasi }}</p>
                        <p class="card-text">Buka: {{ $item->jam_operasional }}</p>
                        <p class="card-text rental-price">Anak-anak - Rp. {{ $item->harga_anak }}</p>
                        <p class="card-text rental-price">Dewasa - Rp. {{ $item->harga_dewasa }}</p>
                        <div class="btn-sewa">
                            <a href="{{ route('pesan_tiket', $item->id) }}" class="btn btn-danger">Pesan Tiket</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mb-9"></div>

    <div class="container">
        <h5 class="">Pilihan Tiket Wisata</h5>
        <div class="row">
            <br>
            <div class="col-md-9">
                <p style="color: black;">Pergi ke tempat baru untuk mendapatkan pengalaman? Kamu bisa mendapatkan
                    pengalaman baru dengan mengunjungi tempat wisata ini.</p>
            </div>
            <div class="col">
                <a href="" class="btn btn-light"> Lihat Semua</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="card col-md-6">
                <div class="card" style="width: 60rem;">
                    <div class="card-body">
                        <h3 class="card-title mb-3">Backpacking Balige</h3>
                        <p class="card-text">Travelling adalah pengalaman unik karena merupakan cara terbaik untuk
                            melepaskan diri dari dorongan dan tarikan kehidupan sehari-hari. Ini membantu kita melupakan
                            masalah, frustrasi, dan ketakutan kita di rumah. Selama travelling, kita menjalani hidup
                            dengan cara yang berbeda. Kita menjelajahi tempat, budaya, masakan, tradisi, dan cara hidup
                            baru.</p>
                        <a href="#" class="btn btn-danger mt-3">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 card">
                <img src="{{ asset('asset/tiket/6.png') }}" alt="" style="width: 100%;">
            </div>

        </div>
    </div>

    <div class="mb-3"></div>

    <div class="container">
        <div class="heading heading-center mb-1">

        </div><!-- End .tab-content -->
    </div><!-- End .container -->

    <div class="container">
        <hr class="mt-1 mb-6">
    </div><!-- End .container -->


</main><!-- End .main -->

@endsection
