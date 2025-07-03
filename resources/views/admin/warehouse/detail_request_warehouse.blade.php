@extends('admin/layout/main')

@section('title', 'Admin - Bank')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/warehouse.css') }}">
@endsection

@section('container')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="col-12 warehouse pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="title-warehouse text-uppercase">Request Warehouse</p>
                    </div>
                    <div class="col-12">
                        <form action="{{ route('admin.accept.warehouse.update', $warehouses->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-7 p-0">
                                    <p>Nama Toko : <span>Kripik Pisang Meinoel</span></p>
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Jenis Produk*</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="jenis_produk">
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->category_id }}"
                                                    @if ($warehouses->category_id == $item->category_id) selected @endif>
                                                    {{ $item->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Produk*</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            name="nama_produk" value="{{ $warehouses->product_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Expired Date</label>
                                        <input type="date" class="form-control" id="exampleInputEmail1"
                                            name="expired_date"
                                            value="{{ date('Y-m-d', strtotime($warehouses->expired_at)) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Deskripsi Produk</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi_produk">{{ $warehouses->product_description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Harga</label>
                                        <div class="input-group mb-3 d-flex align-items-center">
                                            <div class="input-group-prepend">
                                                Rp
                                            </div>
                                            <input type="number" class="form-control m-0 ml-3" name="harga"
                                                value="{{ $warehouses->price }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Berat</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    name="berat" value="{{ $warehouses->heavy }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jumlah</label>
                                                <input type="number" class="form-control" id="exampleInputEmail1"
                                                    name="jumlah" value="{{ $warehouses->stok }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <p class="fw-bold">Gambar Produk</p>
                                    <div class="upload-image-warehouse-box border">
                                        <input type="file" name="upload-image" id="upload-image-warehouse">
                                        <img class="add-image-warehouse-produk" id="add-image-warehouse-produk"
                                            src="{{ asset('images/' . $warehouses->image) }}" alt=""
                                            srcset="">
                                    </div>
                                </div>
                                <div class="col-12 p-0">
                                    <button type="submit" name="simpan_produk" class="btn btn-success m-0">Simpan
                                        Produk</button>
                                    <button type="button" class="btn btn-danger m-0" data-toggle="modal"
                                        data-target="#exampleModal">Tolak Permintaan</button>
                                </div>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Alasan Penolakan</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1">Isikan Alasan Penolakan..</label>
                                                    <textarea name="alasan_ditolak" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger" name="tolak_produk">Tolak Permintaan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('custom_script')
    <script src="{{ asset('asset/js/warehouse.js') }}"></script>
@endsection
