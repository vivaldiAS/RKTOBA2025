console.log("hello");
let map;
$.ajax({
    type: "GET",
    dataType: "json",
    url: "/ambil_lokasi",
    data: "url=" + "province",
    complete: function (data) {
        console.log(data);
        data.then((result) => {
            var _data = $.parseJSON(result);
            _data["rajaongkir"]["results"].forEach((province) => {
                $("#province").append($('<option>', {
                    value: province["province_id"],
                    text: province["province"],
                }));
            });
        })
    }
});


$("#province").change(function (data) {
    console.log($("#province option:selected").text());
    $("#province_name").val($("#province option:selected").text());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/ambil_lokasi",
        data: "url=" + "city?province=" + $(this).val(),
        complete: function (data) {
            console.log(data);

            $("#city").empty();
            $("#city").append('<option value="" disabled selected>Pilih Kabupaten/Kota</option>');

            $("#subdistrict").empty();
            $("#subdistrict").append('<option value="" disabled selected>Pilih Kecamatan</option>');

            data.then((result) => {
                var _data = $.parseJSON(result);

                _data["rajaongkir"]["results"].forEach((city) => {
                    $("#city").append($('<option>', {
                        value: city["city_id"],
                        text: city["city_name"],
                    }))
                });
            })
        }
    });
});


$("#city").change(function (data) {
    console.log($("#city option:selected").text());
    $("#city_name").val($("#city option:selected").text());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/ambil_lokasi",
        data: "url=" + "subdistrict?city=" + $(this).val(),
        complete: function (data) {
            console.log(data);

            $("#subdistrict").empty();
            $("#subdistrict").append('<option value="" disabled selected>Pilih Kecamatan</option>');

            data.then((result) => {
                var _data = $.parseJSON(result);
                _data["rajaongkir"]["results"].forEach((subdistrict) => {
                    $("#subdistrict").append($('<option>', {
                        value: subdistrict["subdistrict_id"],
                        text: subdistrict["subdistrict_name"],
                    }))
                });
            })
        }
    });
});

$("#subdistrict").change(function (data) {
    console.log($("#subdistrict option:selected").text());
    $("#subdistrict_name").val($("#subdistrict option:selected").text());
});

$("#voucher_pembelian").change(function (data) {
    console.log($(this).val());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/ambil_voucher_pembelian",
        data: {voucher: $(this).val(), merchant_id: $merchant_id, total_harga_checkout: $total_harga_checkout},
        success: function (data) {
            console.log(data)

            $("#disabled_service").remove();
            $("#disabled_service").append('<option value="" id="disabled_service" disabled selected>Pilih Servis</option>');

            $("#disabled_voucher_ongkir").remove();
            $("#voucher_ongkos_kirim").append('<option value="" id="disabled_voucher_ongkir" disabled selected>Pilih Voucher Ongkos Kirim</option>');
            $("#voucher_ongkir_table").hide();

            function format_rupiah(nominal) {
                var reverse = nominal.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                return ribuan = ribuan.join('.').split('').reverse().join('');
            }

            // $total_harga_checkout_mentah = parseInt(data);

            $potongan_pembelian = parseInt(data["potongan"]);
            $target_metode_pembelian = data["target_metode_pembelian"];

            $("#jumlah_potongan_subtotal").empty();
            $("#jumlah_potongan_subtotal").append($('<input>', {
                name: "potongan_pembelian",
                value: $potongan_pembelian,
                hidden: "hidden",
            }))

            $("#jumlah_potongan_subtotal").show();
            $("#jumlah_potongan_subtotal").append($('<td>', {text: "Voucher Pembelian: "}))
            $("#jumlah_potongan_subtotal").append($('<td>', {text: "- Rp." + format_rupiah($potongan_pembelian),}))

            $("#total_harga_checkout").empty();
            $("#total_harga_checkout").append($('<a>', {text: "Rp." + format_rupiah(parseInt($total_harga_checkout) + parseInt($ongkir) - parseInt($potongan_pembelian) - parseInt($potongan_ongkir)),}))
        }
    });
});

$("#voucher_ongkos_kirim").change(function (data) {
    console.log($(this).val());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/ambil_voucher_ongkos_kirim",
        data: {voucher_ongkir: $(this).val()},
        success: function (data) {
            console.log(data)

            function format_rupiah(nominal) {
                var reverse = nominal.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                return ribuan = ribuan.join('.').split('').reverse().join('');
            }

            $potongan_ongkir = parseInt(data);

            // $potongan_ongkos_kirim = parseInt(data);

            $ongkir_hasil_potong = parseInt($ongkir) - parseInt($potongan_ongkir);

            if ($ongkir > $potongan_ongkir) {
                $potongan_ongkir = parseInt(data);
            } else if ($ongkir <= $potongan_ongkir) {
                $potongan_ongkir = $ongkir;
            }

            $("#total_harga_checkout").empty();

            $("#total_harga_checkout").append($('<a>', {text: "Rp." + format_rupiah(parseInt($total_harga_checkout) + parseInt($ongkir) - parseInt($potongan_pembelian) - parseInt($potongan_ongkir)),}))

            $("#total_potongan_ongkir").empty();
            $("#total_potongan_ongkir").append($('<td>', {text: "Voucher Ongkos Kirim: "}))
            $("#total_potongan_ongkir").append($('<td>', {text: "- Rp." + format_rupiah($potongan_ongkir),}))

            $("#total_harga_checkout").append($('<input>', {
                name: "ongkir",
                value: $ongkir,
                hidden: "hidden",
            }))

        }
    });
});


$("#metode_pembelian").change(function (data) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/pilih_metode_pembelian",
        data: {tipe: $(this).val(), merchant_id: $merchant_id},
        success: function (data) {
            console.log(data)

            $metode_pembelian = data;

            $tipe = data["tipe"];
            $foreach_option_voucher = data["foreach_option_voucher"];
            $get_pembelian_vouchers_ambil_ditempat = data["get_pembelian_vouchers_ambil_ditempat"];
            $get_pembelian_vouchers_pesanan_dikirim = data["get_pembelian_vouchers_pesanan_dikirim"];

            if ($tipe == "ambil_ditempat") {
                $("#map").addClass("hidden");
                $("#voucher_pembelian").empty();

                if ($get_pembelian_vouchers_ambil_ditempat.length === 0) {
                    $("#disabled_vmethod").remove();
                    $("#voucher_pembelian_td").append('<input class="form-control" id="disabled_vmethod" value="Tidak ada voucher pembelian pada metode pembelian ini." disabled>');
                    $("#voucher_pembelian").hide();
                } else {
                    $("#disabled_vmethod").hide();
                    $("#voucher_pembelian").show();
                    $("#voucher_pembelian").append($foreach_option_voucher);
                }

                $("#province_address").append('<option value="" disabled selected>Pilih Provinsi</option>');
                $("#alamat_table").hide();
                $("#province_address_row").hide();
                $("#province_address").empty();
                $("#province_address").append('<option value="" disabled selected>Pilih Provinsi</option>');
                $("#city_address_row").hide();
                $("#city_address").empty();
                $("#city_address").append('<option value="" disabled selected>Pilih Kabupaten/Kota</option>');
                $("#subdistrict_address_row").hide();
                $("#subdistrict_address").empty();
                $("#subdistrict_address").append('<option value="" disabled selected>Pilih Alamat Kecamatan</option>');
                $("#pengiriman_table").hide();
                $("#pengiriman_lokal_tr").hide();
                $("#service_row").hide();
                $("#disabled_voucher_ongkir").remove();
                $("#voucher_ongkos_kirim").append('<option value="" id="disabled_voucher_ongkir" disabled selected>Pilih Voucher Ongkos Kirim</option>');
                $("#voucher_ongkir_table").hide();

                $("#checkout").empty();

                $("#checkout").append($('<button>', {
                    class: "btn btn-primary btn-order btn-block",
                    text: "Beli Sekarang",
                }))
            } else if ($tipe == "pesanan_dikirim") {
                $("#voucher_pembelian").empty();

                if ($get_pembelian_vouchers_pesanan_dikirim.length === 0) {
                    $("#disabled_vmethod").remove();
                    $("#voucher_pembelian_td").append('<input class="form-control" id="disabled_vmethod" value="Tidak ada voucher pembelian pada metode pembelian ini." disabled>');
                    $("#voucher_pembelian").hide();
                } else {
                    $("#disabled_vmethod").hide();
                    $("#voucher_pembelian").show();
                    $("#voucher_pembelian").append($foreach_option_voucher);
                }

                $("#alamat_table").show();

                $("#disabled_alamat").remove();
                $("#street_address").append('<option value="" id="disabled_alamat" disabled selected>Pilih Alamat Pengiriman</option>');

                $("#checkout").empty();
            }

            function format_rupiah(nominal) {
                var reverse = nominal.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                return ribuan = ribuan.join('.').split('').reverse().join('');
            }

            $("#invoice_ongkir").empty();
            $("#total_potongan_ongkir").empty();

            $ongkir = 0;
            $potongan_ongkir = 0;
            $potongan_pembelian = 0;

            $("#jumlah_potongan_subtotal").empty();
            $("#jumlah_potongan_subtotal").hide();

            $("#total_harga_checkout").empty();
            $("#total_harga_checkout").append($('<a>', {text: "Rp." + format_rupiah(parseInt($total_harga_checkout) + parseInt($ongkir) - parseInt($potongan_pembelian) - parseInt($potongan_ongkir)),}))
        }
    });
});
let locMarker = null;
let destMarker = null;

$("#street_address").change(function (data) {
    console.log($(this).val());
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/ambil_jalan",
        data: {id: $(this).val(), merchant_id: $merchant_id},
        success: function (data) {
            console.log(data)

            $location = data["filtered"];
            $shipping_local = data["shipping_local"];
            $merchant_address = data["merchant_address"];

            $("#province_address_row").show();
            $("#province_address").empty();
            $("#city_address_row").show();
            $("#city_address").empty();
            $("#subdistrict_address_row").show();
            $("#subdistrict_address").empty();

            $("#courier_tr").show();
            $("#courier").empty();
            $("#courier").append('<option value="" selected>Pilih Kurir</option>');

            $("#pengiriman_lokal").empty();
            $("#pengiriman_lokal").append('<option value="" selected>Pilih Pengiriman</option>');

            $("#service_row").hide();

            $("#disabled_voucher_ongkir").remove();
            $("#voucher_ongkos_kirim").append('<option value="" id="disabled_voucher_ongkir" disabled selected>Pilih Voucher Ongkos Kirim</option>');
            $("#voucher_ongkir_table").hide();

            $("#checkout").empty();

            $("#province_address").append($('<option>', {
                value: $location["province_id"],
                text: $location["province"],
                selected: true,
            }))

            $("#city_address").append($('<option>', {
                value: $location["city_id"],
                text: $location["city"],
                selected: true,
            }))

            $("#subdistrict_address").append($('<option>', {
                value: $location["subdistrict_id"],
                text: $location["subdistrict_name"],
                selected: true,
            }))

            $("#pengiriman_table").show();
            $("#courier").append($('<option>', {value: "pos", text: "POS Indonesia",}))
            $("#courier").append($('<option>', {value: "jne", text: "JNE",}))
            $("#courier").append($('<option>', {value: "antar", text: "ANTAR",}))

            $("#servis_row").hide();

            $("#invoice_ongkir").empty();
            $("#total_potongan_ongkir").empty();
            $ongkir = 0;
            $potongan_ongkir = 0;

            if ($shipping_local) {
                $("#pengiriman_lokal_tr").show();
                $("#pengiriman_lokal_td").append($('<input>', {
                    type: "text",
                    name: "service",
                    value: "Toko | " + $location["subdistrict_name"],
                    hidden: "hidden",
                }))

                $("#pengiriman_lokal").append($('<option>', {
                    value: "pengiriman_lokal",
                    text: "Pengiriman Lokal Oleh Toko",
                }))

                $ongkir = parseInt($shipping_local["biaya_jasa"]);

                $('#pengiriman_lokal').change(function () {
                    $("#courier_tr").hide();
                    $("#courier").empty();

                    $("#voucher_ongkir_table").show();

                    $("#disabled_voucher_ongkir").remove();
                    $("#voucher_ongkos_kirim").append('<option value="" id="disabled_voucher_ongkir" disabled selected>Pilih Voucher Ongkos Kirim</option>');

                    $("#total_potongan_ongkir").empty();
                    $potongan_ongkir = 0;

                    $("#invoice_ongkir").empty();
                    $("#invoice_ongkir").append($('<td>', {text: "Ongkos Kirim: "}))
                    $("#invoice_ongkir").append($('<td>', {text: "Rp." + format_rupiah($ongkir),}))

                    $("#total_harga_checkout").empty();
                    $("#total_harga_checkout").append($('<a>', {text: "Rp." + format_rupiah(parseInt($total_harga_checkout) + parseInt($ongkir) - parseInt($potongan_pembelian) - parseInt($potongan_ongkir)),}))

                    $("#total_harga_checkout").append($('<input>', {
                        name: "ongkir",
                        value: $ongkir,
                        hidden: "hidden",
                    }))

                    $("#checkout").empty();
                    $("#checkout").append($('<button>', {
                        class: "btn btn-primary btn-order btn-block",
                        text: "Beli Sekarang",
                    }))

                });
            }

            if (!$shipping_local) {
                $("#pengiriman_lokal_tr").hide();
            }

            function format_rupiah(nominal) {
                var reverse = nominal.toString().split('').reverse().join(''),
                    ribuan = reverse.match(/\d{1,3}/g);
                return ribuan = ribuan.join('.').split('').reverse().join('');
            }
        }
    });
});

function initMap(){
    let mapLayer = document.getElementById("map");

    navigator.geolocation.getCurrentPosition(function (pos) {
        let currentlat = pos.coords.latitude;
        let currentLng = pos.coords.longitude;
        let centerCoordinates = new google.maps.LatLng(currentlat, currentLng);
        let defaultOptions = {center: centerCoordinates, zoom: 15};
        map = new google.maps.Map(mapLayer, defaultOptions);

        map.addListener("click", function (event) {
            if(locMarker == null || destMarker == null){
                addMarkers(event.latLng);
            }
        });
    })
}
let markers = [{}, {}];
function addMarkers(location){
    if(locMarker == null){
        locMarker = new google.maps.Marker({
            position: location,
            map: map,
        });
        locMarker.addListener("click", function () {
            locMarker.setMap(null);
            locMarker = null;
        });
        markers[0] = location;
    }else if(destMarker == null){
        destMarker = new google.maps.Marker({
            position: location,
            map: map,
        });
        destMarker.addListener("click", function () {
            destMarker.setMap(null);
            destMarker = null;
        });
        markers[1] = location;
    }

    if(locMarker != null && destMarker != null){
        let directService = new google.maps.DirectionsService();
        let directRender = new google.maps.DirectionsRenderer();
        directRender.setMap(map);
        const route = {
            origin: markers[0],
            destination: markers[1],
            travelMode: "DRIVING",
        };

        directService.route(route, function (response, status) {
            if(status === 'OK'){
                console.log(response);
                directRender.setDirections(response);
                let distance = response.routes[0].legs[0].distance;
                console.log(distance);
                let priceOngkir = (distance.value / 1000).toFixed(1) * 2000;

                console.log(priceOngkir);

                $potongan_ongkir = 0;

                $("#checkout").empty();
                $("#checkout").append($('<button>', {
                    class: "btn btn-primary btn-order btn-block",
                    text: "Beli Sekarang",
                }))

                $("#total_harga_checkout").empty();
                $("#total_harga_checkout").append($('<a>', {text: "Rp." + format_rupiah(parseInt($total_harga_checkout) + parseInt(priceOngkir) - parseInt($potongan_pembelian) - parseInt($potongan_ongkir)),}))

                $ongkir = priceOngkir;

                $("#invoice_ongkir").empty();
                $("#invoice_ongkir").append($('<td>', {text: "Ongkos Kirim: "}))
                $("#invoice_ongkir").append($('<td>', {text: "Rp." + format_rupiah(priceOngkir),}))

                $("#total_harga_checkout").append($('<input>', {
                    name: "ongkir",
                    value: $ongkir,
                    hidden: "hidden",
                }))

            }
        });
    }
}



$("#courier").change(function (data) {
    console.log();
    if ($(this).val() === 'antar') {

        $("#map").removeClass("hidden");

    } else {
        $("#map").addClass("hidden");
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/cek_ongkir",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: "origin=" + $subdistrict_id + "&originType=subdistrict" + "&destinationType=subdistrict" + "&destination=" + $("#subdistrict_address").val() + "&weight=" + $total_berat + "&courier=" + $("#courier").val(),
            complete: function (data) {
                console.log(data);
                $("#checkout").empty();

                $("#service").empty();
                $("#service").append('<option value="" disabled selected>Pilih Servis</option>');

                $("#disabled_voucher_ongkir").remove();
                $("#voucher_ongkos_kirim").append('<option value="" id="disabled_voucher_ongkir" disabled selected>Pilih Voucher Ongkos Kirim</option>');
                $("#voucher_ongkir_table").hide();
                $("#pengiriman_lokal_tr").hide();
                $("#pengiriman_lokal").empty();
                $("#service_row").hide();

                data.then((result) => {
                    var _data = $.parseJSON(result);
                    _data["rajaongkir"]["results"].forEach((costs, indexC) => {

                        costs["costs"].forEach((cost, indexCC) => {

                            cost["cost"].forEach((price) => {
                                $("#service_row").show();
                                $("#service").append($('<option>', {
                                    value: cost["description"],
                                    text: cost["description"] + " ( " + price["etd"] + " hari )",
                                    tarif: price["value"],
                                }))

                                $('#service').change(function () {

                                    $("#voucher_ongkir_table").show();

                                    $("#disabled_voucher_ongkir").remove();
                                    $("#voucher_ongkos_kirim").append('<option value="" id="disabled_voucher_ongkir" disabled selected>Pilih Voucher Ongkos Kirim</option>');

                                    $("#total_potongan_ongkir").empty();
                                    $potongan_ongkir = 0;

                                    $("#checkout").empty();
                                    $("#checkout").append($('<button>', {
                                        class: "btn btn-primary btn-order btn-block",
                                        text: "Beli Sekarang",
                                    }))

                                    var ongkir = $(this).find('option:selected').attr('tarif')

                                    $("#total_harga_checkout").empty();
                                    $("#total_harga_checkout").append($('<a>', {text: "Rp." + format_rupiah(parseInt($total_harga_checkout) + parseInt($ongkir) - parseInt($potongan_pembelian) - parseInt($potongan_ongkir)),}))

                                    $ongkir = parseInt(ongkir);

                                    $("#invoice_ongkir").empty();
                                    $("#invoice_ongkir").append($('<td>', {text: "Ongkos Kirim: "}))
                                    $("#invoice_ongkir").append($('<td>', {text: "Rp." + format_rupiah(ongkir),}))

                                    $("#total_harga_checkout").append($('<input>', {
                                        name: "ongkir",
                                        value: $ongkir,
                                        hidden: "hidden",
                                    }))
                                })

                            });
                        });
                    });
                })
            }
        });
    }
});

function format_rupiah(nominal) {
    var reverse = nominal.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
    return ribuan = ribuan.join('.').split('').reverse().join('');
}
