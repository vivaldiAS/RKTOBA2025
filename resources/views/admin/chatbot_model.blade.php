@extends('admin/layout/main')

@section('title', 'Admin - Carousel')

@section('container')

    <link rel="stylesheet" href="{{ asset('asset/css/chatbot_model.css') }}"/>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tabel Model</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tabel Model</li>
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
                                <div class="col-12 ">
                                    <div class="row">
                                        <div class="col-12 col-md-6 d-flex align-items-center">
                                            <select id="select-model" class="form-control shadow-sm">
                                                <option>Pilih Model</option>
                                            </select>
                                            <button id="activate-model" class="btn btn-primary">Aktifkan Model</button>
                                        </div>
                                        <div class="col-12 col-md-6 d-flex justify-content-end mb-3">
                                            <button id="check-fine-tune" class="btn btn-primary mr-3">Check Fine Tune Status</button>
                                            <button id="fine-tune" class="btn btn-success">Fine Tune Model</button>
                                        </div>
                                    </div>
                                </div>
                                <table id="example1" class="table mt-4 table-bordered table-hover">
                                    <thead align="center">
                                    <tr>
                                        <th>Nama Model</th>
                                        <th>Tanggal Train</th>
                                        <th>Tanggal Active</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $d)
                                        <tr>
                                            <td>{{ $d->name  }}</td>
                                            <td>{{ $d->train_date  }}</td>
                                            <td>{{ $d->active_date  }}</td>
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

    <div id="custom-model" class="custom-modal shadow-sm px-3 py-1 rounded-sm hide">
        <div class="d-flex justify-content-end">
            <button id="close-modal-button">
                <span class="text-danger">X</span>
            </button>
        </div>
        <div id="icon-message" class="icon-modal d-flex justify-content-center">

        </div>
        <div id="message" class="my-3 d-flex justify-content-center">
        </div>
    </div>

    <!-- /.modal -->
@endsection

@section("script")
    <script >
        let token = "{{env("OPENAI_TOKEN")}}";
    </script>
    <script src="{{ asset('asset/js/admin_chatbot.js')  }}"></script>
@endsection
