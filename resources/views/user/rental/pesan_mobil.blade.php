@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')


@section('container')

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <img alt="Test" src="{{ asset('asset/Image/rental_image/' . explode(',', $mobil->gambar)[0] ) }}" alt="">
        </div>
        <div class="col-md-4">
            <h3>{{ $mobil->nama }}</h3>
            <p>Spesifikasi</p>
            <div class="shadow d-flex p-3 rounded">
                <p>{{ $mobil->kapasitas_penumpang }} Orang</p>
                <p class="ml-4">{{ $mobil->mode_transmisi }}</p>
                <p class="ml-4">{{ $mobil->lokasi }}</p>
                <p class="ml-4">{{ $mobil->tipe_driver }}</p>
            </div>

            <h4 class="mt-5">{{ $mobil->harga_sewa_per_hari }} / Hari</h4>

            <form action="{{ route('pesan_rental', $mobil->id) }}" method="POST">
                @csrf
                <input type="hidden" id="price" value="{{ $mobil->harga_sewa_per_hari }}">
                <div class="form-group">
                    <label for="tanggal_mulai_sewa">Pilih Tanggal Rental</label>
                    <input id="tanggal_mulai_sewa" class="form-control" type="date" name="tanggal_mulai_sewa" min="<?php echo date('Y-m-d')?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_akhir_sewa">Pilih Tanggal Pengembalian</label>
                    <input id="tanggal_akhir_sewa" class="form-control" type="date" name="tanggal_akhir_sewa" min="<?php echo date('Y-m-d')?>">
                </div>
                <div class="form-group">
                    <label for="total_price">Total Harga</label>
                    <input id="total_price" class="form-control" type="text" name="total_price" disabled>
                </div>

                <button onclick="submitForm()" class="btn btn-primary">Sewa</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

    const startDateInput = document.getElementById('tanggal_mulai_sewa');
    const endDateInput = document.getElementById('tanggal_akhir_sewa');
    const priceInput = document.getElementById('price');
    const totalPriceInput = document.getElementById('total_price');


    startDateInput.addEventListener("change", calculateTotalPrice);
    endDateInput.addEventListener("change", calculateTotalPrice);
    priceInput.addEventListener("change", calculateTotalPrice);

    function calculateTotalPrice() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const price = priceInput.value;

        if (startDateInput.value && endDateInput.value && priceInput.value) {
            const duration = (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24);
            const totalPrice = duration * price;

            totalPriceInput.value = formatRupiah(totalPrice);
        }
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
    }

    function submitForm() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);
        const price = priceInput.value;

        const duration = (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24);
        const totalPrice = duration * price;

        totalPriceInput.value = totalPrice;

        totalPriceInput.value = totalPrice;
        const disabledInput = document.getElementById('total_price');
        disabledInput.removeAttribute('disabled');
        document.querySelector('form').submit();
        disabledInput.removeAttribute('readonly');
    }

</script>
@endsection
