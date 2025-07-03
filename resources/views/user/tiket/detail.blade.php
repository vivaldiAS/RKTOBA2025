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
</style>

@section('container')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

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
            <div class="row mt-3">
                <div class="row card col-lg-8">
                    <div class="col-md-8">
                        <h6 class="mt-2">{{ $tiket->nama }}</h6>
                        <p>Lokasi: {{ $tiket->lokasi }}</p>
                        <p>Jam Operasional: {{ $tiket->jam_operasional }}</p>
                    </div>
                    <div class="main-nav">
                            <div class="main-nav">
                                <svg preserveAspectRatio="xMidYMin meet" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="__GOERS_location-content_icon" style="width: 30px; height: 30px;">
                                    <path d="M8.154 1C5.31222 1 3 3.31222 3 6.15429C3 6.89561 3.15173 7.60341 3.45075 8.25819C4.7394 11.078 7.21009 14.0552 7.93679 14.9004C7.99124 14.9636 8.07062 15 8.15415 15C8.23768 15 8.31705 14.9636 8.3715 14.9004C9.09792 14.0554 11.5686 11.0783 12.8577 8.25819C13.1568 7.60341 13.3084 6.89561 13.3084 6.15429C13.3081 3.31222 10.9959 1 8.154 1ZM8.154 8.83144C6.67781 8.83144 5.47671 7.63034 5.47671 6.15415C5.47671 4.67781 6.67781 3.47671 8.154 3.47671C9.6302 3.47671 10.8313 4.67781 10.8313 6.15415C10.8314 7.63034 9.63034 8.83144 8.154 8.83144Z"
                                    fill="currentColor"></path>
                                </svg>
                                <div class="main-nav">
                                    <div class="main-nav">
                                        Museum Batak TB Silalahi Center
                                    </div>
                                    <div class="main-nav" data-testid="___location-contentdata_address">"Jl. DR. TB Silalahi No. 88, Silalahi Pagar Batu, Balige, Silalahi Pagar Batu, Balige, Kabupaten Toba, Balige, Toba Samosir Kabupaten, Sumatera Utara, Indonesia"</div>
                                    <button class="main-nav" onclick="viewOnMap()">View on Map</button>

                                    <script>
                                        function viewOnMap() {
                                            window.open("https://goo.gl/maps/JJ6wx9iWc1VRpwPE8", "_blank");
                                        }
                                    </script>
                                    <!-- <button class="sc-dkPtRN jSnFok __GOERS_anchor" type="button" href="https://goo.gl/maps/JJ6wx9iWc1VRpwPE8">View on Map</button> -->
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card col-lg-4">
                    <div>
                        <h6 class="mt-2">Pesanan Tiket Anda</h6>
                        <form action="{{ route('pesan_tiket', $tiket->id) }}" method="POST">
                            @csrf
                            <input type="hidden" id="hargaAnak" value="{{ $tiket->harga_anak }}">
                            <input type="hidden" id="hargaDewasa" value="{{ $tiket->harga_dewasa }}">
                            <div class="form-group">
                                <label for="tanggal_berkunjung">Pilih Tanggal Berkunjung</label>
                                <input id="tanggal_berkunjung" class="form-control" type="date" name="tanggal_berkunjung" min="<?php echo date('Y-m-d')?>">
                            </div>

                            <div class="form-group">
                                <label for="jumlah_anak">Anak-anak</label>
                                <input id="id-1" class="form-control" type="number" name="jumlah_anak" placeholder="Jumlah Anak-anak">
                                <input type="hidden" min="0" max="1000" step="0.1" id="id-4" class="form-control" name="" value="{{ ($tiket->harga_anak)}}" onfocus="this.placeholder = ''"
                                         onblur="this.placeholder = 'anak'">
                            </div>

                            <div class="form-group">
                                <label for="jumlah_dewasa">Dewasa</label>
                                <input id="id-2" class="form-control" type="number" name="jumlah_dewasa" placeholder="Jumlah Dewasa">
                                <input type="hidden" min="0" max="1000" step="0.1" id="id-5" class="form-control" name="" value="{{ ($tiket->harga_dewasa)}}" onfocus="this.placeholder = ''"
                                         onblur="this.placeholder = 'dewasa'">
                            </div>

                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <input id="total_harga"  class="form-control id-3" type="number" name="total_harga" readonly>
                            </div>

                            <button type="submit" class="btn btn-danger text-right">Pesan Tiket</button>
                        </form>
                    </div>
                </div>
            </div><!-- End .container -->

            <div class="mb-9"></div>


            <div class="mb-3"></div>

            <div class="container">
                <div class="heading heading-center mb-1">

                </div><!-- End .tab-content -->
            </div><!-- End .container -->

            <div class="container">
                <hr class="mt-1 mb-6">
            </div><!-- End .container -->


    </main><!-- End .main -->
    <script>
        $(function() {
                $("#id-1, #id-2, #id-4, #id-5").keyup(function() {
                     $(".id-3").val((+$("#id-1").val() * +$("#id-4").val()) + (+$("#id-2").val() * +$("#id-5").val()));
                     var sum = +$("#id-1").val() + (+$("#id-2").val());
                   console.log(formatRupiah(sum));
                   if(sum == 0) {
                     $('input[name="go"]').prop('disabled', false);
                   } else {
                     $('input[name="go"]').prop('disabled', true);
                   }
                });
            });
            $(document).on('keyup', '.number-decimal', function(e) {
                var regex = /[-+][^\d.]|\.(?=.*\.)/g;
                var subst = "";
                var str = $(this).val();
                var result = str.replace(regex, subst);
                $(this).val(result);
            });

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
    }
    </script>
@endsection
