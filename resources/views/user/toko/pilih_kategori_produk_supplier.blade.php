@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    @foreach($categories as $categories)
        <a href="../tambah_produk_supplier/{{$categories->category_id}}" class="btn btn-link btn-link-dark" style="margin-bottom:3px">{{$categories->nama_kategori}}</a>
    @endforeach
</div><!-- .End .tab-pane -->

@endsection

