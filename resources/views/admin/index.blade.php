@extends('admin/layout/main')

@section('title', 'Rumah Kreatif Toba - Admin')

@section('container')

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$jumlah_pesanan}}</h3>

              <p>Total Pesanan</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="./daftar_pembelian" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
        
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$jumlah_pesanan_perlu_konfirmasi}}</h3>

              <p>Perlu Konfirmasi</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="./daftar_pembelian" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$jumlah_pengguna}}</h3>

              <p>Total Pengguna</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="./user" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div> -->

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$jumlah_pengguna_perlu_verifikasi}}</h3>

              <p>Pengguna Perlu Verifikasi</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="./user" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$jumlah_toko}}</h3>

              <p>Total Toko</p>
            </div>
            <a href="./toko_user" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div> -->

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$jumlah_toko_perlu_verifikasi}}</h3>

              <p>Toko Perlu Verifikasi</p>
            </div>
            <a href="./toko_user" class="small-box-footer">Info Lanjut <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
        <!-- <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
      </div>

      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3 id="total_pembelian">-</h3>

              <p>Jumlah Pembelian</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
          </div>
        </div>
        <div>
          <p>Waktu Pembelian</p>
          <input type="date" class="small-box" id="tanggal_awal_pembelian" max="<?php echo date("Y-m-d") ?>">
          <input type="date" class="small-box" id="tanggal_akhir_pembelian" max="<?php echo date("Y-m-d") ?>">
        </div>
      </div>
      <div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead align="center">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Kode Pembelian</th>
                            <th>Nama</th>
                            <th>Toko</th>
                            <th>Status Pesanan</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Detail</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchasesDB as $item)
                            <tr>
                                <td>{{ $item->purchase_id }}</td>
                                <td>{{ $item->kode_pembelian }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->nama_merchant }}</td>
                                <?php
                                  $status_pembelian = "";
                                  if($item->status_pembelian == "status1" || $item->status_pembelian == "status1_ambil"){
                                    if($item->proof_of_payment_image){
                                      $status_pembelian = "Bukti Pembayaran Telah Dikirim. SILAHKAN KONFIRMASI.";
                                    }
                                    else{
                                      $status_pembelian = "Belum Dapat Dikonfirmasi. TUNGGU BUKTI PEMBAYARAN.";
                                    }
                                  }
                                ?>
                                <td>{{$status_pembelian}}</td>
                                <td>{{ $item->created_at }}</td>
                                <td><button data-purchaseID="{{ $item->purchase_id }}" class="btn-detail btn btn-info">Lihat Detail</button></td>
                                <td>
                                    @if($item->proof_of_payment_image)
                                        @if($cek_admin_id->is_admin == 1)
                                            <a href="./update_status_pembelian/{{$item->purchase_id}}" class="btn btn-block btn-info">Konfirmasi Pembayaran</a>
                                        @endif
                                    @endif
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

<br><br><br>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <p>Data Pembelian</p>

                <!-- Form Pencarian -->
                <form id="searchForm" method="GET" action="{{ route('admin.searchPurchases') }}">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="startDate">Tanggal Awal</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" value="{{ request('startDate') }}">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="endDate">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" value="{{ request('endDate') }}">
                        </div>
                        <div class="form-group col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>
                <div id="totalProfit" style="margin-top: 10px; display: none;">
                  <strong>Total Keuntungan: <span id="profitAmount"></span></strong> 
                </div>
                <table id="example2" class="table table-bordered table-hover">
                    <thead align="center">
                        <tr>
                            <th>No</th>
                            <th>Purchase Order</th>
                            <th>Nama Produk</th>
                            <th>Nama Toko</th>
                            <th>Jumlah Produk</th>
                            <th>Harga per Unit</th>
                            <th>Total Harga</th>
                            <th>Tanggal Pemesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchasesAPI as $key => $purchase)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $purchase['kode_pembelian'] }}</td>
                                <td>{{ $purchase['product_name'] }}</td>
                                <td>{{ $purchase['nama_merchant'] }}</td>
                                <td>{{ $purchase['jumlah_pembelian_produk'] }}</td>
                                <td>{{ $purchase['price'] }}</td>
                                <td>{{ $purchase['price'] * $purchase['jumlah_pembelian_produk'] }}</td>
                                <td>{{ $purchase['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        <!-- /.card -->
      </div>
  <!-- /.col -->
</div>

      <div class="modal" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Detail Pemesanan</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
              <ul id="list-products"></ul>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>
      
      
      <!-- <div class="row">
        <section class="col-lg-7 connectedSortable">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Sales
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
                <div class="chart tab-pane active" id="revenue-chart"
                      style="position: relative; height: 300px;">
                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                  </div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                  <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="card direct-chat direct-chat-primary">
            <div class="card-header">
              <h3 class="card-title">Direct Chat</h3>

              <div class="card-tools">
                <span title="3 New Messages" class="badge badge-primary">3</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                  <i class="fas fa-comments"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            
            <div class="card-body">
              <div class="direct-chat-messages">
                <div class="direct-chat-msg">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                  </div>
                  <img class="direct-chat-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user1-128x128.jpg') }}" alt="message user image">
                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable!
                  </div>
                </div>

                <div class="direct-chat-msg right">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right">Sarah Bullock</span>
                    <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                  </div>
                  <img class="direct-chat-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user3-128x128.jpg') }}" alt="message user image">
                  <div class="direct-chat-text">
                    You better believe it!
                  </div>
                </div>

                <div class="direct-chat-msg">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">Alexander Pierce</span>
                    <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                  </div>
                  <img class="direct-chat-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user1-128x128.jpg') }}" alt="message user image">
                  <div class="direct-chat-text">
                    Working with AdminLTE on a great new app! Wanna join?
                  </div>
                </div>

                <div class="direct-chat-msg right">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right">Sarah Bullock</span>
                    <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                  </div>
                  <img class="direct-chat-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user3-128x128.jpg') }}" alt="message user image">
                  <div class="direct-chat-text">
                    I would love to.
                  </div>
                </div>

              </div>

              <div class="direct-chat-contacts">
                <ul class="contacts-list">
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user1-128x128.jpg') }}" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          Count Dracula
                          <small class="contacts-list-date float-right">2/28/2015</small>
                        </span>
                        <span class="contacts-list-msg">How have you been? I was...</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user7-128x128.jpg') }}" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          Sarah Doe
                          <small class="contacts-list-date float-right">2/23/2015</small>
                        </span>
                        <span class="contacts-list-msg">I will be waiting for...</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user3-128x128.jpg') }}" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          Nadia Jolie
                          <small class="contacts-list-date float-right">2/20/2015</small>
                        </span>
                        <span class="contacts-list-msg">I'll call you back at...</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user5-128x128.jpg') }}" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          Nora S. Vans
                          <small class="contacts-list-date float-right">2/10/2015</small>
                        </span>
                        <span class="contacts-list-msg">Where is your new...</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user6-128x128.jpg') }}" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          John K.
                          <small class="contacts-list-date float-right">1/27/2015</small>
                        </span>
                        <span class="contacts-list-msg">Can I take a look at...</span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <img class="contacts-list-img" src="{{ URL::asset('asset/AdminLTE/dist/img/user8-128x128.jpg') }}" alt="User Avatar">

                      <div class="contacts-list-info">
                        <span class="contacts-list-name">
                          Kenneth M.
                          <small class="contacts-list-date float-right">1/4/2015</small>
                        </span>
                        <span class="contacts-list-msg">Never mind I found...</span>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            
            <div class="card-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                  <span class="input-group-append">
                    <button type="button" class="btn btn-primary">Send</button>
                  </span>
                </div>
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                To Do List
              </h3>

              <div class="card-tools">
                <ul class="pagination pagination-sm">
                  <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                  <li class="page-item"><a href="#" class="page-link">1</a></li>
                  <li class="page-item"><a href="#" class="page-link">2</a></li>
                  <li class="page-item"><a href="#" class="page-link">3</a></li>
                  <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                </ul>
              </div>
            </div>
            
            <div class="card-body">
              <ul class="todo-list" data-widget="todo-list">
                <li>
                  <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <div  class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="" name="todo1" id="todoCheck1">
                    <label for="todoCheck1"></label>
                  </div>
                  <span class="text">Design a nice theme</span>
                  <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                  <div class="tools">
                    <i class="fas fa-edit"></i>
                    <i class="fas fa-trash-o"></i>
                  </div>
                </li>
                <li>
                  <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <div  class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                    <label for="todoCheck2"></label>
                  </div>
                  <span class="text">Make the theme responsive</span>
                  <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                  <div class="tools">
                    <i class="fas fa-edit"></i>
                    <i class="fas fa-trash-o"></i>
                  </div>
                </li>
                <li>
                  <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <div  class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="" name="todo3" id="todoCheck3">
                    <label for="todoCheck3"></label>
                  </div>
                  <span class="text">Let theme shine like a star</span>
                  <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                  <div class="tools">
                    <i class="fas fa-edit"></i>
                    <i class="fas fa-trash-o"></i>
                  </div>
                </li>
                <li>
                  <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <div  class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="" name="todo4" id="todoCheck4">
                    <label for="todoCheck4"></label>
                  </div>
                  <span class="text">Let theme shine like a star</span>
                  <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                  <div class="tools">
                    <i class="fas fa-edit"></i>
                    <i class="fas fa-trash-o"></i>
                  </div>
                </li>
                <li>
                  <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <div  class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="" name="todo5" id="todoCheck5">
                    <label for="todoCheck5"></label>
                  </div>
                  <span class="text">Check your messages and notifications</span>
                  <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                  <div class="tools">
                    <i class="fas fa-edit"></i>
                    <i class="fas fa-trash-o"></i>
                  </div>
                </li>
                <li>
                  <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                  </span>
                  <div  class="icheck-primary d-inline ml-2">
                    <input type="checkbox" value="" name="todo6" id="todoCheck6">
                    <label for="todoCheck6"></label>
                  </div>
                  <span class="text">Let theme shine like a star</span>
                  <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                  <div class="tools">
                    <i class="fas fa-edit"></i>
                    <i class="fas fa-trash-o"></i>
                  </div>
                </li>
              </ul>
            </div>
            
            <div class="card-footer clearfix">
              <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
            </div>
          </div>
        </section>
        <section class="col-lg-5 connectedSortable">

          <div class="card bg-gradient-primary">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-map-marker-alt mr-1"></i>
                Visitors
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>
                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>
                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>
              </div>
              
            </div>
          </div>

          <div class="card bg-gradient-info">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-th mr-1"></i>
                Sales Graph
              </h3>

              <div class="card-tools">
                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                  <div class="text-white">Mail-Orders</div>
                </div>
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                  <div class="text-white">Online</div>
                </div>
                <div class="col-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                          data-fgColor="#39CCCC">

                  <div class="text-white">In-Store</div>
                </div>
              </div>
              
            </div>
          </div>

          <div class="card bg-gradient-success">
            <div class="card-header border-0">

              <h3 class="card-title">
                <i class="far fa-calendar-alt"></i>
                Calendar
              </h3>
              <div class="card-tools">
                <div class="btn-group">
                  <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                    <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu" role="menu">
                    <a href="#" class="dropdown-item">Add new event</a>
                    <a href="#" class="dropdown-item">Clear events</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">View calendar</a>
                  </div>
                </div>
                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            
            <div class="card-body pt-0">
              <div id="calendar" style="width: 100%"></div>
            </div>
            
          </div>
        </section>
      </div> -->
    </div>
  </section>
</div>
@endsection


@section("custom_script")
<script>
  $(".btn-detail").on( "click", function() {
    function format_rupiah(nominal){
        var  reverse = nominal.toString().split('').reverse().join(''),
              ribuan = reverse.match(/\d{1,3}/g);
          return ribuan	= ribuan.join('.').split('').reverse().join('');
    }
    
    let data = $(this).data("purchaseid");

    $.ajax({url:`/purchase/detail/${data}`, success: function(result){
      $("#list-products").empty();
      console.log(result)
      result.products.forEach(product => {
        if(product.harga_pembelian_produk == null){
          harga_pembelian_produk = product.price * product.jumlah_pembelian_produk;
        }
        
        else if(product.harga_pembelian_produk != null){
          harga_pembelian_produk = product.harga_pembelian_produk;
        }

        if(result.claim_pembelian_voucher){
          result.target_kategori.forEach(get_target_kategori => {
            potongan_subtotal_perproduk = harga_pembelian_produk * result.claim_pembelian_voucher.potongan / 100;

            if(result.jumlah_potongan_subtotal < result.claim_pembelian_voucher.maksimal_pemotongan){
                if(product.category_id == get_target_kategori){
                    potongan_harga_barang = potongan_subtotal_perproduk;
                }

                else{
                    potongan_harga_barang = 0;
                }
            }

            else if(result.jumlah_potongan_subtotal >= result.claim_pembelian_voucher.maksimal_pemotongan){
                if(product.category_id == get_target_kategori){
                    potongan_harga_barang = harga_pembelian_produk / result.subtotal_harga_produk_terkait_seluruh * result.claim_pembelian_voucher.maksimal_pemotongan;
                }

                else{
                    potongan_harga_barang = 0;
                }
            }

            harga_pembelian_produk_terpotong = harga_pembelian_produk - potongan_harga_barang;

            if(harga_pembelian_produk_terpotong < 0){
              harga_pembelian_produk_terpotong = 0;
            }
          
            if(result.claim_pembelian_voucher){
              get_harga_pembelian_produk_terpotong = "Rp." + format_rupiah(harga_pembelian_produk_terpotong) + " dari ";
            }

            else{
              get_harga_pembelian_produk_terpotong = "";
            }

            if(product.category_id == get_target_kategori){
              cek_target_kategori = product.category_id;
              
              total_harga_pembelian_keseluruhan_beli = result.semua_total_harga_pembelian - result.jumlah_potongan_subtotal;

              $("#list-products").append(`<li>Product ID: ${product.product_id} | Nama Produk: ${product.product_name} |  Jumlah Pembelian: ${product.jumlah_pembelian_produk}  | Harga: ${get_harga_pembelian_produk_terpotong} Rp.${format_rupiah(harga_pembelian_produk)}</li>`)
            }
          });
        }
        
        else if(!result.claim_pembelian_voucher){
          $("#list-products").append(`<li>Product ID: ${product.product_id} | Nama Produk: ${product.product_name} |  Jumlah Pembelian: ${product.jumlah_pembelian_produk}  | Harga: Rp.${format_rupiah(harga_pembelian_produk)}</li>`)
        }
      });

      if(!result.claim_pembelian_voucher){
        $("#list-products").append(`<br><center><a>TOTAL HARGA PEMBELIAN: Rp.${format_rupiah(result.semua_total_harga_pembelian)}</a></center><br>`)

        if(result.purchase.courier_code != null && result.purchase.service != null){
          if(result.claim_ongkos_kirim_voucher){
            total_bayar = parseInt(result.semua_total_harga_pembelian) + parseInt(result.ongkir_get_voucher);
            
            $("#list-products").append(`<center><a>KURIR yang digunakan: ${result.courier_name} - ${result.purchase.service} dengan biaya ONGKOS KIRIM Rp.${format_rupiah(result.ongkir_get_voucher)} dari Rp.${format_rupiah(result.ongkir)}</a></center><br>`)
          }
          else if(!result.claim_ongkos_kirim_voucher){
            total_bayar = parseInt(result.semua_total_harga_pembelian) + parseInt(result.ongkir);
            
            $("#list-products").append(`<center><a>KURIR yang digunakan: ${result.courier_name} - ${result.purchase.service} dengan biaya ONGKOS KIRIM Rp.${format_rupiah(result.ongkir)}</a></center><br>`)
          }
          total_bayar_ke_penjual = parseInt(result.semua_total_harga_pembelian) + parseInt(result.ongkir);
          $("#list-products").append(`<center><a>TOTAL PEMBAYARAN PEMBELI: Rp.${format_rupiah(total_bayar)}</a></center><br>`)
          $("#list-products").append(`<center><a>TOTAL PEMBAYARAN KE PENJUAL: Rp.${format_rupiah(total_bayar_ke_penjual)}</a></center><br>`)
        }
      }

      else if(result.claim_pembelian_voucher){
        $("#list-products").append(`<br><center><a>TOTAL HARGA PEMBELIAN: Rp.${format_rupiah(total_harga_pembelian_keseluruhan_beli)}</a></center><br>`)
        $("#list-products").append(`<center><a>TOTAL HARGA PEMBELIAN SEBELUM PEMOTONGAN: Rp.${format_rupiah(result.semua_total_harga_pembelian)}</a></center><br>`)

        if(result.purchase.courier_code != null && result.purchase.service != null){
          if(result.claim_ongkos_kirim_voucher){
            total_bayar = parseInt(total_harga_pembelian_keseluruhan_beli) + parseInt(result.ongkir_get_voucher);
            
            $("#list-products").append(`<center><a>KURIR yang digunakan: ${result.courier_name} - ${result.purchase.service} dengan biaya ONGKOS KIRIM Rp.${format_rupiah(result.ongkir_get_voucher)} dari Rp.${format_rupiah(result.ongkir)}</a></center><br>`)
          }
          else if(!result.claim_ongkos_kirim_voucher){
            total_bayar = parseInt(result.total_harga_pembelian_keseluruhan_beli) + parseInt(result.ongkir);
            
            $("#list-products").append(`<center><a>KURIR yang digunakan: ${result.courier_name} - ${result.purchase.service} dengan biaya ONGKOS KIRIM Rp.${format_rupiah(result.ongkir)}</a></center><br>`)
          }
          total_bayar_ke_penjual = parseInt(result.semua_total_harga_pembelian) + parseInt(result.ongkir);
          $("#list-products").append(`<center><a>TOTAL PEMBAYARAN PEMBELI: Rp.${format_rupiah(total_bayar)}</a></center><br>`)
          $("#list-products").append(`<center><a>TOTAL PEMBAYARAN KE PENJUAL: Rp.${format_rupiah(total_bayar_ke_penjual)}</a></center><br>`)
        }
      }

      if(result.purchase.no_resi != null){
        $("#list-products").append(`<center><a>Slahkan <a href="https://cekresi.com/?noresi=${result.purchase.no_resi}" target="_blank"><b>CEK</b></a> nomor resi: ${result.purchase.no_resi} [${result.courier_name}]</a></center><br>`)
      }

      if(result.proof_of_payment){
        $("#list-products").append(`<center><a href="./asset/u_file/proof_of_payment_image/${result.proof_of_payment.proof_of_payment_image}" target="_blank">Lihat Foto Bukti Pembayaran</a></center>`)
      }
      
      else if(!result.proof_of_payment){
        $("#list-products").append(`<center><a>Belum dapat dikonfirmasi. MENUNGGU PEMBAYARAN</a></center>`)
      }

      $('#myModal').modal('show');
    }});

  });
  document.getElementById("tanggal_akhir_pembelian").disabled = true;
  </script>
</script>

<script src="{{ URL::asset('asset/js/function_4.js') }}"></script>

<script>
    function formatRupiah(angka) {
      var reverse = angka.toString().split('').reverse().join(''),
          ribuan = reverse.match(/\d{1,3}/g);
      ribuan = ribuan.join('.').split('').reverse().join('');
      return ribuan;
    }
    function searchPurchases() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        fetch(`{{ route('admin.searchPurchases') }}?startDate=${startDate}&endDate=${endDate}`)
            .then(response => response.json())
            .then(data => {
                console.log('Fetched data:', data);
                const purchases = data.purchasesAPI;
                const tbody = document.querySelector('#example2 tbody');
                let totalProfit = 0;

                tbody.innerHTML = '';

                purchases.forEach((purchase, index) => {
                    const row = document.createElement('tr');
                    const profit = purchase.price * purchase.jumlah_pembelian_produk;
                    totalProfit += profit;

                    row.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${purchase.kode_pembelian}</td>
                        <td>${purchase.product_name}</td>
                        <td>${purchase.nama_merchant}</td>
                        <td>${purchase.jumlah_pembelian_produk}</td>
                        <td>${purchase.price}</td>
                        <td>${profit}</td>
                        <td>${purchase.created_at}</td>
                    `;

                    tbody.appendChild(row);
                });
                document.getElementById('profitAmount').innerText = `Rp ${formatRupiah(totalProfit)}`;

            })
            .catch(error => console.error('Error:', error));
    }
    function showTotalProfit() {
      document.getElementById('totalProfit').style.display = 'block';
    }

    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        searchPurchases();
        showTotalProfit();
    });

</script>
@endsection