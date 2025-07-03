@extends('admin/layout/main')

@section('title', 'Admin - Carousel')

@section('container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tabel Carousel</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tabel Carousel</li>
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
              <div class="card-header">
                @if($cek_admin_id->is_admin == 1)
                  <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-tambah_carousel">Tambah Carousel</button>
                @elseif($cek_admin_id->is_admin == 2)
                  <button type="button" class="btn btn-block btn-info" disabled>Tambah Carousel</button>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>ID Carousel</th>
                        <th>Gambar Carousel</th>
                        <th>Link Carousel</th>
                        <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($carousels as $carousels)
                    <tr>
                        <td>{{$carousels->id}}</td>
                        <td><a href="./asset/u_file/carousel_image/{{$carousels->carousel_image}}" target="_blank">{{$carousels->carousel_image}}</a></td>
                        <td>{{$carousels->link_carousel}}</td>
                        @if($cek_admin_id->is_admin == 1)
                          <td align="center" width="150px">
                              <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#modal-edit-{{$carousels->id}}">Edit</button>
                          </td>
                          <td align="center" width="100px">
                              <a href="./hapus_carousel/{{$carousels->id}}" class="btn btn-block btn-danger">Hapus</a>
                          </td>
                        @elseif($cek_admin_id->is_admin == 2)
                          <td align="center" width="150px">
                              <button type="button" class="btn btn-block btn-info" disabled>Edit</button>
                          </td>
                          <td align="center" width="100px">
                              
                          </td>
                        @endif
                    </tr>

                    <div class="modal fade" id="modal-edit-{{$carousels->id}}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Carousel</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card card-primary">
                                    <!-- form start -->
                                    <form action="./PostEditCarousel/{{$carousels->id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                      <div class="form-group">
                                        <label for="customFile">Gambar Carousel</label>
                                        <div class="custom-file">
                                          <input type="file" class="custom-file-input" id="customFile" name="carousel_image" accept="image/*">
                                          <label class="custom-file-label" for="customFile">{{$carousels->carousel_image}}</label>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                          <label for="link_carousel">Link Carousel</label>
                                          <input type="text" class="form-control" name="link_carousel" id="link_carousel" value="{{$carousels->link_carousel}}" placeholder="Masukkan link carousel.">
                                      </div>
                                      <div class="form-group">
                                        <label for="open_in_new_tab">Buka Pada Tab Baru</label>
                                        @if($carousels->open_in_new_tab == 1)
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" id="open_in_new_tab_ya" name="open_in_new_tab" value="1" checked required>
                                          <label class="form-check-label" for="open_in_new_tab_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" id="open_in_new_tab_tidak" name="open_in_new_tab" value="0" required>
                                          <label class="form-check-label" for="open_in_new_tab_tidak">Tidak</label>
                                        </div>
                                        @elseif($carousels->open_in_new_tab == 0)
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" id="open_in_new_tab_ya" name="open_in_new_tab" value="1" required>
                                          <label class="form-check-label" for="open_in_new_tab_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" id="open_in_new_tab_tidak" name="open_in_new_tab" value="0" checked required>
                                          <label class="form-check-label" for="open_in_new_tab_tidak">Tidak</label>
                                        </div>
                                        @endif
                                      </div>
                                    </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
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

<div class="modal fade" id="modal-tambah_carousel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Carousel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                <!-- form start -->
                <form action="PostTambahCarousel" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="customFile">Gambar Carousel</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="customFile" name="carousel_image" accept="image/*" required>
                          <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                      </div>
                      <div class="form-group">
                          <label for="link_carousel">Link Carousel</label>
                          <input type="text" class="form-control" name="link_carousel" id="link_carousel" placeholder="Masukkan link carousel.">
                      </div>
                      <div class="form-group">
                        <label for="open_in_new_tab">Buka Pada Tab Baru</label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="open_in_new_tab_ya" name="open_in_new_tab" value="1" required>
                          <label class="form-check-label" for="open_in_new_tab_ya">Ya</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" id="open_in_new_tab_tidak" name="open_in_new_tab" value="0" required>
                          <label class="form-check-label" for="open_in_new_tab_tidak">Tidak</label>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection