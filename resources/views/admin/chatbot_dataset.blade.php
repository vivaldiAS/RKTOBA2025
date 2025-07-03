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
                        <h1>Tabel Dataset</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tabel Dataset</li>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="col-12 d-flex justify-content-end mb-3">
                                    <a href="/admin/chatbot/add-dataset" class="btn btn-success">Tambahkan Dataset</a>
                                </div>
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead align="center">
                                    <tr>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                        <th>Tanggal Ditambahkan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $d)
                                        <tr>
                                            <td>{{ $d->question  }}</td>
                                            <td>{{ $d->answers  }}</td>
                                            <td>{{ $d->created_at  }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-5">
                                    {{ $data->links() }}
                                </div>
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

    <!-- /.modal -->
@endsection
