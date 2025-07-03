@extends('admin/layout/main')

@section('title', 'Admin - Pembelian')

@section('container')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Daftar Pemesanan Tiket Experience</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Daftar Pemesanan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead align="center">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Jumlah Tiket Anak</th>
                        <th>Jumlah Tiket Dewasa</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($tikets as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->tanggal_pemesanan }}</td>
                      <td>{{ $item->jumlah_anak }} Orang</td>
                      <td>{{ $item->jumlah_dewasa }} Orang</td>
                      <td>Rp {{ number_format($item->total_harga. 0) }}</td>
                      <td> <button type="button" class="btn btn-success">Success</button> </td>
                      {{-- <td>{{ $item-> }}</td> --}}
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
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

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
</script>
@endsection