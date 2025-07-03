@extends('admin/layout/main')

@section('title', 'Admin - Galery - Checkout')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/checkout.css') }}">
@endsection

@section('container')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-9">
                        <p class="title-warehouse text-uppercase">Gallery Checkout </p>
                    </div>
                    <div class="col-sm-3">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Galery</li>
                            <li class="breadcrumb-item active">Checkout</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content pb-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 bg-white px-0">
                        <div class="table-product-selected position-relative">
                            <div class="row">
                                <div class="col-md-1 bg-dark text-center p-3">#</div>
                                <div class="col-md-5 bg-dark text-center p-3">Item</div>
                                <div class="col-md-3 bg-dark text-center p-3">Quantity</div>
                                <div class="col-md-3 bg-dark text-center p-3">Total</div>
                            </div>
                            <div id="box-items-selected">

                            </div>
                        </div>
                        <div class=" text-right w-100">
                            <p class="mr-3 font-weight-bold " id="total">Total : Rp. 0,00 -</p>
                        </div>
                        <div class="p-0 d-flex">
                            <button class="btn btn-danger w-50 rounded-0">Batalkan Pesanan</button>
                            <button class="btn btn-success w-50 rounded-0" id="payment_confirm">Konfirmasi
                                Pembayaran</button>
                        </div>
                    </div>
                    <div class="col-md-6 p-3 bg-white">
                        <div class="row pb-2 border-bottom" id="search-row">
                            <div class="col-md-1" id="search-icon">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </div>
                            <div class="col-md-10 text-center">Semua Kategori</div>
                            <div class="col-md-1"><i class="fa fa-filter" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="row" id="search-form-row" style="display:none;">
                            <div class="col-md-12">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control" placeholder="Cari produk...">
                                    <div class="col-md-2 bg-danger  d-flex align-items-center justify-content-center" id="icon-close" >
                                        <i class="fa fs-xl2 fa-times" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row product-box-container">
                            @foreach ($gallery as $item)
                                <div class="col-md-4 mt-2 text-left card-product position-relative d-flex flex-column"
                                    onclick="addItem('{{ $item->id }}', '{{ $item->product_name }}', '{{ $item->price }}', '{{ $item->stok }}')">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRTOpE5KgNv4atd-sngWvRV36UvIpixs4kmWw&usqp=CAU"
                                        alt="" srcset="">
                                    <div class="text-left py-2 px-2 border card-product-body user-select-none" id="card-product-{{ $item->id }}">
                                        <p class="card-product-title">{{ $item->product_name }}</p>
                                        <p class="card-product-merchant">{{ $item->category->nama_kategori }}</p>
                                        <p class="card-product-merchant" id="stok-{{ $item->id }}">Stok : {{ $item->stok }}</p>
                                        <p class="card-product-price">Rp.{{ $item->price }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection


@section('custom_script')
    <script src="{{ asset('asset/js/checkout.js') }}"></script>
@endsection
