// var offset = 0;
// var limit = 5;

// function loadItems() {
//     $.ajax({
//         url: '/produk',
//         type: 'GET',
//         data: { offset: offset, limit: limit },
//         success: function(response) {
//             console.log(data)
//             var produk = response.produk;
//             // Render produk
//             showItems(produk);
//             // Increase offset for next request
//             offset += limit;
//             // Check if there are more produk to load
//             if (produk.length < limit) {
//                 $('#load-more-button').hide();
//             }
//         },
//         error: function(xhr, status, error) {
//             console.log(error);
//         }
//     });
// }

// function showItems(produk) {
//     // Render produk to DOM
// }


$(document).ready(function() {
    var page = 1;
    var kategori_produk_id = $kategori_produk_id;

    if($kategori_produk_id == 0){
        if($produk_ditemukan >= 0){
            var cari = $cari;
            $('#more_button').on('click', function() {
                page++;
                $.ajax({
                    url: "/cari/" + cari + "?page=" + page,
                    type: "GET",
                    dataType: "html",
                    success: function (html) {
                        $("#show_product").append(html);
                    }
                })
                
                .done(function (html) {
                    if (html.length == 0) {
                        $("#more_button").remove();
                        $('#more').html("<span class='font-medium text-gray-700 bg-white'>Tidak Produk Lain</span>");
                    }
                })
            });
        }

        else if($merchant_id != 0){
            var merchant_id = $merchant_id;
            $('#more_button').on('click', function() {
                page++;
                $.ajax({
                    url: "/produk/toko[" + merchant_id + "]?page=" + page,
                    type: "GET",
                    dataType: "html",
                    success: function (html) {
                        $("#show_product").append(html);
                    }
                })
                
                .done(function (html) {
                    if (html.length == 0) {
                        $("#more_button").remove();
                        $('#more').html("<span class='font-medium text-gray-700 bg-white'>Tidak Produk Lain</span>");
                    }
                })
            });
        }
        
        else{
            $('#more_button').on('click', function() {
                page++;
                $.ajax({
                    url: "/produk?page=" + page,
                    type: "GET",
                    dataType: "html",
                    success: function (html) {
                        $("#show_product").append(html);
                    }
                })
                
                .done(function (html) {
                    if (html.length == 0) {
                        $("#more_button").remove();
                        $('#more').html("<span class='font-medium text-gray-700 bg-white'>Tidak Produk Lain</span>");
                    }
                })
            });
        }
    }

    else if($kategori_produk_id != 0){
        $('#more_button').on('click', function() {
            page++;
            $.ajax({
                url: "/produk/kategori[" + kategori_produk_id + "]?page=" + page,
                type: "GET",
                dataType: "html",
                success: function (html) {
                    $("#show_product").append(html);
                }
            })
            
            .done(function (html) {
                if (html.length == 0) {
                    $("#more_button").remove();
                    $('#more').html("<span class='font-medium text-gray-700 bg-white'>Tidak Produk Lain</span>");
                }
            })
        });
    }
});


// var page = 1;

// LoadMoreButton(page);

// $('#more_button').on('click', function() {
//     page++;
//     LoadMoreButton(page);
// });

// function LoadMoreButton(page) {
//     $.ajax({
//         url: "/produk?page=" + page,
//         datatype: "html",
//         type: "get",
//         beforeSend: function () {
//             $('#show_product').show();
//         }
//     })
//     .done(function (response) {
//         if (response.length == 0) {
//             $('#more_button').html("We don't have more data to display :(");
//             return;
//         }
//         // $('.auto-load').hide();
//         $("#show_product").append(response);
//     })
//     // .fail(function (jqXHR, ajaxOptions, thrownError) {
//     //     console.log('Server error occured');
//     // });
// };


// loadItems();