@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Gallery')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
@endsection

@section('container')
    <div class="col-12 warehouse">
        <div class="d-flex justify-content-between align-items-center">
            <p class="title-warehouse text-uppercase">Request Gallery</p>
        </div>
        <div class="col-12">
            <form action="{{ route('gallery.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-7 p-0">
                        <p>Nama Toko : <span>{{ auth()->user()->merchant->nama_merchant }}</span></p>
                        @csrf
                        <span class="btn btn-warning my-3 choose-warehouse" id='choose-warehouse' data-toggle="modal"
                            data-target="#warehouse-modal"> Pilih dari Warehouse</span>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Jenis Produk*</label>
                            <select class="form-control" id="jenis_produk" name="jenis_produk">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->category_id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Produk*</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Expired Date</label>
                            <input type="date" class="form-control" id="expired_date" name="expired_date">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi_produk" rows="3" name="deskripsi_produk"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Harga</label>
                            <div class="input-group mb-3 d-flex align-items-center">
                                <div class="input-group-prepend">
                                    Rp
                                </div>
                                <input type="number" class="form-control m-0 ml-3" id="harga" name="harga">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Berat</label>
                                    <input type="number" class="form-control" id="berat" name="berat">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <p class="fw-bold">Gambar Produk</p>
                        <div class="upload-image-warehouse-box border">
                            <input type="hidden" name="upload_image" id="upload-image-gallery">
                            <img class="add-image-warehouse-produk" id="add-image-warehouse-produk"
                                src="{{ asset('asset/image/image_upload.png') }}" alt="" srcset="">
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <button class="btn btn-success m-0">Request</button>
                    </div>
                </div>
            </form>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="warehouse-modal" tabindex="-1" role="dialog" aria-labelledby="warehouse-modal-Title"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" style="max-width: 800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-4">
                        <div class="d-flex mt-2">
                            <input type="text" class="input-search" placeholder="Cari Produk" id="query">
                            <button class="btn btn-warning ml-3">Search</button>
                        </div>

                        <div class="container-fluid py-5 px-0">
                            <div class="row" id="product_container">

                            </div>
                        </div>
                        <div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination"  id="pagination">

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('asset/js/warehouse.js') }}"></script>
    <script src="{{ asset('asset/js/gallery.js') }}"></script>
@endsection
