@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

@section('container')
<div class="container">
    <form action=" {{ route('checkout') }} " enctype="multipart/form-data" method="post">
    @csrf

    <div class="row">
        <div class="col-md-12 mb-4">
            <h3 class="my-5 text-left ">Detail Pemesanan</h3>
        </div>

        <div class="col-md-6">
            <img class="text-center" src="{{ asset('asset/Image/rental_image/' . explode(',', $pemesanan->mobil->gambar)[0]) }}" alt="">

        </div>
        <div class="col-md-6">
            <h4>{{ $pemesanan->mobil->nama }}</h4>
            <b class="mt-3">Spesifikasi:</b>
            <p>{{ $pemesanan->mobil->warna }}</p>
            <p>{{ $pemesanan->mobil->mode_transmisi }}</p>
            <p>{{ $pemesanan->mobil->tipe_driver }}</p>
            <p>{{ $pemesanan->mobil->lokasi }}</p>
            <p>{{ $pemesanan->mobil->kapasitas_penumpang }}</p>
            <p>Rp {{ number_format($pemesanan->total_harga) }}</p>
            <input type="hidden" class="form-control" name="total_harga"
            value="{{ $pemesanan->total_harga }}" required>

            <button onclick="submitForm()" class="col-md-3 btn btn-primary mb-3">Bayar</button>
            <a href="{{ route('cancel.rental', $pemesanan->id) }}" class="col-md-3 btn btn-danger mb-3">Cancel</a>
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
