@extends('admin/layout/main')

@section('title', 'Admin - Produk Grosir')

@section('container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabel Produk Grosir</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Tabel Produk Grosir</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title"></h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>ID Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori Produk</th>
                        <th>Nama Toko</th>
                        <th>Spesifikasi Produk</th>
                        <th>Stok</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $products)
                    <tr>
                        <td>{{$products->product_id}}</td>
                        <td>{{$products->product_name}}</td>
                        <td>{{$products->nama_kategori}}</td>
                        <td>{{$products->nama_merchant}}</td>
                        <td>
                            <?php
                              $jumlah_product_specifications = DB::table('product_specifications')->where('product_id', $products->product_id)->count();
                            ?>
                            @if($jumlah_product_specifications == 0)

                            @else
                                @foreach($product_specifications as $product_specification)
                                    @if($product_specification->product_id == $products->product_id)
                                        <a>{{$product_specification->nama_spesifikasi}}</a><a>,</a>
                                    @endif
                                @endforeach   
                            @endif   
                        </td>
                        <td>
                            @foreach($stocks as $stock)
                                @if($stock->product_id == $products->product_id)
                                    <a>{{$stock->stok}}</a>
                                @endif
                            @endforeach      
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection