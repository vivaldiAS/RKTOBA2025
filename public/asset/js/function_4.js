$("#tanggal_awal_pembelian").change(function (data) {
    document.getElementById("tanggal_akhir_pembelian").disabled = false;
    document.getElementById("tanggal_akhir_pembelian").value = "";
    document.getElementById("tanggal_akhir_pembelian").setAttribute("min", document.getElementById("tanggal_awal_pembelian").value);
});

$("#tanggal_akhir_pembelian").change(function (data) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/jumlah_pembelian",
        data: {tanggal_awal_pembelian: document.getElementById("tanggal_awal_pembelian").value, tanggal_akhir_pembelian: $(this).val()},
        success: function (data) {
            console.log(data)
            $jumlah_pembelian = data["jumlah_pembelian"];
            console.log($jumlah_pembelian)

            $("#total_pembelian").empty();
            $("#total_pembelian").append($('<a>', {text: $jumlah_pembelian,}))
        }
    });
});