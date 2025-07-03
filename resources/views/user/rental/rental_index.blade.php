@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba -Experience| Beranda Rental Mobil ')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Toko</li>

@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('container')

    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 rounded">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" href="{{ url('/rental/mobil') }}">Beranda</a>
                            <a class="nav-link" href="{{ route('pesan_rental.index') }}">Pemesanan</a>
                            <a class="nav-link" href="{{ url('/rental/list_mobil') }}">Mobil Anda</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    {{-- <div class="card p-5" style="border-color: black;">
    <div class="bg-danger p-4 d-flex justify-content-between">
        <h5 class="card-header" style="color:white">
            <i class="fa-sharp fa-solid fa-bell"></i>&nbsp;
            Pesanan Terbaru
        </h5>
        <table style="color:whitesmoke">
            <tr>
                <td>20 Februari 2023</td>
                <td>|</td>
                <td>15:00 WIB</td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body p-5">
                    <h5 class="card-title">Rahmat Irawan</h5>
                    <p class="card-text">
                    <table>
                        <tr>
                            <th>Tanggal Rental</th>
                            <th>:</th>
                            <td>25 Februari 2023 -27 Februari 2023</td>
                        </tr>
                        <tr>
                            <th>Preferensi Paket</th>
                            <th>:</th>
                            <td>Tanpa Supir</td>
                        </tr>
                    </table>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-sm-4" style="border-left: 1px solid black;">
            <div class="card ">
                <div class="card-body p-5">
                    <table>
                        <tr>
                            <th>Mobil</th>
                            <th>:</th>
                            <td>Toyota Avanza</td>
                        </tr>
                        <tr>
                            <th>Jenis Mobil</th>
                            <th>:</th>
                            <td>Manual</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <div class=" row ">
        <div class=" col-md-6">
            <div class="d-flex align-items-center">
                <div class="p-3">
                    <i class="fa-solid fa-user" style="font-size: 60px;color:#814D4D"></i>
                </div>
                <div class="">
                    <h6 class="card-title">Jumlah Penyewa</h6>
                    <p class="card-text">{{ $pesanan }} Penyewa</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <div class="p-3">
                    <i class="fa-solid fa-car" style="font-size: 60px;color:#814D4D"></i>
                </div>
                <div class="">
                    <h6 class="card-title">Jumlah Mobil</h6>
                    <p class="card-text">{{ $total_mobil }} Mobil</p>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="d-flex align-items-center">
                <div class="p-3">
                    <i class="fa-solid fa-cancel" style="font-size: 60px;color:#814D4D"></i>
                </div>
                <div class="">
                    <h6 class="card-title">Pembatalan</h6>
                    <p class="card-text">7 Pembatalan</p>
                </div>
            </div>
        </div> --}}

    </div>

@endsection
