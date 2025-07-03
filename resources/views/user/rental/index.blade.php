@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<style>
    .intro-slider-container,
    .intro-slide {
        height: 300px;
    }

    .experience-hero {
        background-color: #814D4D;
    }

    .img-rental {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 40%;
        height: 150px;
    }

    .rental-hero {
        width: 100%;
        height: 100%;
    }

    .rental-text-hero {
        width: 80%;
    }

    .menu-rental {
        margin-top: -80px;
        width: 100%;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25);
        border-radius: 15px;
        position: relative;
        background-color: #fff;
    }

    .list-mobil-container {
        width: 100%;
        box-shadow: 0px 3px 8px -1px rgba(0, 0, 0, 0.25);
        border-radius: 14px;
    }

    .img-mobil-list {
        height: 200px;
        object-fit: cover;
    }

    .rental-price {
        font-size: 20px;
        color: #800000;
        font-weight: 600;
    }

    .rental-price span {
        font-size: 20px;
        color: #425466;
        font-weight: 600;
    }

    .rental-title {
        font-size: 24px;
        font-weight: 600;
        color: #425466;
    }

    .form-select-custom {
        width: 100%;
        padding: 10px;
    }

    .btn-custom {
        margin-top: 10px;
        color: white;
        padding: 10px;
        text-align: center;
        display: block;
        width: 100%;
        background-color: #F15743;
    }

    .btn-custom:hover {
        background-color: #c71801;
        color: white;
    }

    .card-mobil-container {
        border: 1px solid #C7C3C3;
        border-radius: 15px;
    }
</style>

@section('container')
<main class="main">
    <div class="experience-hero">
        <div class="row">
            <div class="col-md-6 text-center">
                <img class="rental-hero" src="{{ asset('asset/rental_image/image-hero.png') }}" alt="">
            </div>
            <div class="col-md-6 p-5 m-auto">
                <div class="rental-text-hero">
                    <h2 class="text-white">FAST AND EASY WAY TO RENT A CAR</h2>
                    <p class="text-white">Looking for unbeatable deals on a car rental ? Rent a Hot Rate Car with
                        Hotwire and
                        you'll save up to 50 % * on your rental car . We work with top brand - name rental car to help
                        you find the car rental for your trip .</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5 menu-rental-container">
        <form action="{{ route('cari.rental') }}" method="post">
            @csrf
        <div class="row menu-rental">
                <div class="col-md-9 col-sm-6">
                    <div class="p-5">
                        <select class="form-select-custom" aria-label="Default select example" name="tipe_driver">
                            <option selected>Tipe Driver</option>
                            <option value="Semua">Semua Tipe</option>
                            <option value="Dengan Driver">Dengan Driver</option>
                            <option value="Tanpa Driver">Tanpa Driver</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="p-5">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12 my-5 text-center">
                <p>Best Service</p>
                <h5>Explore Our Top Deal From <br> Top-Rated Dealer</h5>
            </div>
            <div class="col-md-12 list-mobil-container">
                <div class="row">
                    @foreach ($list_mobil as $item)
                    <div class="col-md-4 card-mobil-container">
                        <div class="card">
                            <img class="card-img-top img-mobil-list" src="{{ asset('asset/Image/rental_image/' . explode(',', $item->gambar)[0]) }}" alt="">
                            <div class="card-body">
                                <h5 class="card-title rental-title">{{ $item->nama }}</h5>
                                <p class="card-text rental-price">{{ $item->harga_sewa_per_hari }} <span>/ Hari</span></p>
                                <hr class="m-3">
                                <div class="d-flex flex-md-wrap">
                                    <img src="{{ asset('asset/rental_image/Car Seat.svg') }}" alt="">
                                    <p class="ml-2">{{ $item->mode_transmisi }}</p>
                                    <img src="{{ asset('asset/rental_image/Steering Wheel.svg') }}" class="ml-4" alt="">
                                    <p class="ml-2">{{ $item->tipe_driver }}</p>
                                    <p class="ml-4"><b>{{ $item->kapasitas_penumpang }} Orang</b></p>
                                </div>
                                <div class="d-flex flex-md-wrap mt-2">
                                    <img src="{{ asset('asset/rental_image/Region.svg') }}" alt="">
                                    <p class="ml-2">{{ $item->lokasi }}</p>
                                </div>
                                <h6 class="mt-3">{{ $item->merchant->nama_merchant }}</h6>
                                <div class="btn-sewa">
                                    <a href="{{ route('pesan_rental', $item->id) }}" class="btn-custom rounded">Sewa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main><!-- End .main -->
@endsection
