@extends('admin/layout/main')

@section('title', 'Admin - Carousel')

@section('container')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="p-3">
                                <h3>Tambahkan Dataset</h3>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    @csrf
                                    <div id="content-dataset">

                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <div id="button-add" role="button" class="rounded-circle">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-success" type="submit">Tambahkan dataset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- /.modal -->
@endsection

@section("script")
    <script src="{{ asset('asset/js/add_dataset.js')  }}"></script>
@endsection
