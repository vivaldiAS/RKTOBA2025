$('#select_category').change(function (data) {
    console.log($(this).val())
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/tambah_produk",
        data: { kategori_produk_id: $(this).val()},
        dataType: "html",
        success: function (html) {
            
            $("#div_category_type_specifications").empty();
            $("#div_category_type_specifications").append(html);
        }
    })
});



$("#tambah_produk_keranjang").click(function (data) {
    console.log($(this).val())
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/masuk_keranjang",
        data: { produk: $(this).val()},
        success: function (data) {
            console.log(data)

            $("#jumlah_produk_keranjang").empty();

            $("#jumlah_produk_keranjang").append($('<i>', { class: "icon-shopping-cart", }))

            $("#jumlah_produk_keranjang").append($('<span>', {
                class: "cart-count",
                text: data,
            }))

            jQuery("#tambah_produk_keranjang_modal").modal('show');
        }
    });
});

$("#tambah_produk_keinginan").change(function (data) {
    console.log($(this).val());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/masuk_daftar_keinginan",
        data: { produk: $(this).val() },
        success: function (data) {
            console.log(data)

            $jumlah_produk_keinginan = data["jumlah_produk_keinginan"];
            $produk = data["produk"];

            $("#jumlah_produk_keinginan").empty();

            $("#jumlah_produk_keinginan").append($('<i>', { class: "icon-heart-o", }))

            $("#jumlah_produk_keinginan").append($('<span>', {
                class: "wishlist-count badge",
                text: $jumlah_produk_keinginan,
            }))

            $("#label_tambah_produk_keinginan").hide();
            $("#label_hapus_produk_keinginan").show();

            jQuery("#tambah_produk_keinginan_modal").modal('show');
        }
    });
});

$("#hapus_produk_keinginan").change(function (data) {
    console.log($(this).val());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/hapus_daftar_keinginan",
        data: { produk: $(this).val() },
        success: function (data) {
            console.log(data)
            
            $jumlah_produk_keinginan = data["jumlah_produk_keinginan"];
            $produk = data["produk"];

            $("#jumlah_produk_keinginan").empty();

            $("#jumlah_produk_keinginan").append($('<i>', { class: "icon-heart-o", }))

            $("#jumlah_produk_keinginan").append($('<span>', {
                class: "wishlist-count badge",
                text: $jumlah_produk_keinginan,
            }))

            $("#label_hapus_produk_keinginan").hide();
            $("#label_tambah_produk_keinginan").show();

            jQuery("#hapus_produk_keinginan_modal").modal('show');
        }
    });
});



$("#tipe_voucher").change(function (data) {
    console.log($(this).val());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/pilih_tipe_voucher",
        data: { tipe: $(this).val() },
        success: function (data) {
            console.log(data)

            if(data == "pembelian"){
                $("#div_checkbox_categories").show();
                $("#div_target_metode_pembelian").show();
                $("#potongan_div").show();
                $("#minimal_pengambilan_div").show();
                $("#potongan").remove();
                $("#potongan_div").append($('<input>', {
                    type: "number",
                    class: "form-control",
                    name: "potongan",
                    id: "potongan",
                    min: 0,
                    max: 100,
                    placeholder: "Masukkan potongan yang diberikan voucher. (%)",
                    required: "required",
                }))
                
                $("#maksimal_pemotongan_div").show();
                $("#maksimal_pemotongan").remove();
                $("#maksimal_pemotongan_div").append($('<input>', {
                    type: "number",
                    class: "form-control",
                    name: "maksimal_pemotongan",
                    id: "maksimal_pemotongan",
                    min: 0,
                    placeholder: "Masukkan maksimal potongan belanjaan yang didapat. (Rp)",
                    required: "required",
                }))
                $("#tanggal_voucher").show();
            }

            if(data == "ongkos_kirim"){
                $("#div_checkbox_categories").hide();
                $("#div_target_metode_pembelian").hide();

                $("#potongan_div").show();
                $("#minimal_pengambilan_div").show();
                $("#potongan").remove();
                $("#potongan_div").append($('<input>', {
                    type: "number",
                    class: "form-control",
                    name: "potongan",
                    id: "potongan",
                    placeholder: "Masukkan potongan yang diberikan voucher. (Rp)",
                    required: "required",
                }))
                
                $("#maksimal_pemotongan_div").hide();
                $("#tanggal_voucher").show();
            }
        }
    });
});