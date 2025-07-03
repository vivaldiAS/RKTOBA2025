@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <a class="nav-link btn btn-outline-primary-2" href="./pengiriman_lokal">
        <span>TAMBAH PENGIRIMAN LOKAL</span>
        <i class="icon-long-arrow-right"></i>
    </a>
    <div class="mb-2"></div>
    <div class="row">
    @foreach($shipping_locals as $shipping_local)
        <?php
            $curl = curl_init();
            
            $param = $shipping_local->shipping_local_city_id;
            $subdistrict_id = $shipping_local->shipping_local_subdistrict_id;
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=".$param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array("key: 41df939eff72c9b050a81d89b4be72ba"),
            ));

            $response = curl_exec($curl);
            $collection = json_decode($response, true);
            $filters =  array_filter($collection['rajaongkir']['results'], function($r) use ($subdistrict_id) {
                return $r['subdistrict_id'] == $subdistrict_id;
            });
            
            foreach ($filters as $filter){
                $pengiriman_lokal = $filter;
            }
            
            $err = curl_error($curl);
            curl_close($curl);

            $biaya_jasa = "Rp." . number_format($shipping_local->biaya_jasa,0,',','.');
        ?>
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Pengiriman Lokal {{$loop->iteration}}</h3><!-- End .card-title -->
                    <p>{{$pengiriman_lokal["subdistrict_name"]}}<br>
                    {{$biaya_jasa}}<br>
                    <a href="./hapus_pengiriman_lokal/{{$shipping_local->shipping_local_id}}">Hapus</a></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    @endforeach
    </div><!-- End .row -->
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

