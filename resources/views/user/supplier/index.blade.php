@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

@section('container')
<div class="main">
    <div class="col">
        <div class="row">
            <div class="col-lg-2 wrapper-category pl-5">
                <h5>Kategori supplier</h5>
                <div class="wrapper-category-item pl-4">
                    @foreach($supplier_product_categories as $categories)
                        <a href="/supplier/{{$categories->supplier_product_category_id}}}">{{$categories->nama_kategori_produk_supplier}}</a><br>
                    @endforeach
                </div>
            </div>
            <div class="col wrapper-supplier">
                <div class="row">
                @foreach($supplier_products as $item)
                    <div class="col-lg-2 mr-5 card border">
                        <div class="card-header border">
                            <div class="logo-wrapper">
                                <div class="logo-placeholder">

                                </div>
                                    {{$item->nama_merchant}}
                            </div>
                        </div>
                        <div class="card-body">
                            {{$item->supplier_product_name}}
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

<style>

    .card{
        padding: 0 !important;
        border-radius: 10px !important;
    }
    .card-header{
        border-radius: 10px 0px 0px 0px !important;
        min-height: 7vh;
    }
    .card-body{
        min-height: 25vh;
    }

    .logo-wrapper{
        border-radius: 10px 0px 0px 0px !important;
        background-color: #1E3D59;
        width: 8vh;
        min-height: 7vh;
        display: flex;
    }
    .logo-placeholder{
        position: absolute;
        top: 1em;
        left: 1.35em;
        border-radius: 100%;
        background-color: white;
        width: 40px;
        height: 40px;
    }
</style>
