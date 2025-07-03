@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

@section('container')
<div class="container">
    <form action=" {{ route('checkouttiket') }} " enctype="multipart/form-data" method="post">
    @csrf

    <div class="row">
        <div class="col-md-12 mb-4">
            <h3 class="my-5 text-left ">Detail Pemesanan</h3>
        </div>

        <div class="col-md-6">
            <img class="text-center" src="{{ asset('asset/tiket/4.png') }}" alt="">
        </div>
        <div class="col-md-6">
            <h4>Tiket Masuk Museum</h4>
            <b class="mt-3">Spesifikasi:</b> <br>
            <p>Tanggal Pemesanan: {{ $tiket->tanggal_pemesanan }}</p>
            <p>Jumlah Tiket Anak: {{ $tiket->jumlah_anak }}</p>
            <p>Jumlah Tiket Dewasa: {{ $tiket->jumlah_dewasa }}</p>
            <p>Total Harga: Rp {{ number_format($tiket->total_harga) }}</p>
            <input type="hidden" class="form-control" name="total_harga"
            value="{{ $tiket->total_harga }}" required>
            <br><br>
            <button onclick="submitForm()" class="col-md-3 btn btn-primary mb-3">Bayar</button>
            <a href="{{ route('canceltiket', ['id' => $tiket->id]) }}" class="col-md-3 btn btn-danger mb-3">Cancel</a>
        </div>

    </div>
      </form>
</div>
@endsection

@push('after-script')
    <script>
         var count = 1;
        var countEl = document.getElementById("count");
        function plus(){
            count++;
            countEl.value = count;
        }
        function minus(){
        if (count > 1) {
            count--;
            countEl.value = count;
        }
        }

        $(document).ready(function() {
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: 500,
                title: false,
                tint: '#333',
                Xoffset: 15
            });
        });
        $(".deleteRecord").click(function() {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: "cart/" + id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function() {
                    // console.log("it Works");
                    window.location.assign("{{ url('wisata') }}");
                }
            });
        });
    </script>
@endpush
