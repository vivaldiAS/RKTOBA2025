@extends('user/layout/main')

@section('title', 'Panduan Pengunaan')

@section('container')

<main class="main">
    <div class="page-header text-center" style="background-image: url('asset/Molla/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Panduan Pengunaan<span>Help</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    
    <div class="page-content">
        <div class="container">
        <div class="form-tab">
            <ul class="nav nav-pills nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab_panduan_pembeli" data-toggle="tab" href="#panduan_pembeli" role="tab" aria-controls="panduan_pembeli" aria-selected="true">Pembeli</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab_panduan_penjual" data-toggle="tab" href="#panduan_penjual" role="tab" aria-controls="panduan_penjual" aria-selected="false">Penjual</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="panduan_pembeli" role="tabpanel" aria-labelledby="tab_panduan_pembeli">

                    <div class="row">
                		<div class="col-md-12">
                			<div class="accordion" id="accordion-1">

							    <div class="card card-box card-sm bg-light">
							        <div class="card-header" id="heading-1">
							            <h2 class="card-title">
							                <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
							                    Langkah Pembuatan Akun
							                </a>
							            </h2>
							        </div><!-- End .card-header -->
							        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-1">
                                        <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Pilih Menu Akun.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Setelah itu akan muncul tampilan yang berisi tab masuk dan daftar. Lalu pilih tab Daftar.
                                                </li>
                                                <li class="list-group-item">
                                                    3. Setelah itu akan muncul form untuk mengisi data diri. Pada halaman ini anda diharuskan mengisi nama, username atau nama pengguna, akun email, password akun, jenis kelamin, tanggal lahir dan nomor telepon.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Setelah itu, centang pilihan mengenai kebijakan privasi.
                                                </li>
                                                <li class="list-group-item">
                                                    5. Selanjutnya tekan tombol daftar.
                                                </li>
                                                <li class="list-group-item">
                                                    6. Setelah terdaftar, pengguna akan diarahkan ke halaman utama.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
							        </div><!-- End .collapse -->
							    </div><!-- End .card -->

							    <div class="card card-box card-sm bg-light">
							        <div class="card-header" id="heading-2">
							            <h2 class="card-title">
							                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                Autentikasi Login
							                </a>
							            </h2>
							        </div><!-- End .card-header -->
							        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-1">
							            <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Pilih Menu Akun.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Setelah itu masukkan username dan password yang sudah didaftarkan. Lalu tekan masuk.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
							        </div><!-- End .collapse -->
							    </div><!-- End .card -->

                                <div class="card card-box card-sm bg-light">
							        <div class="card-header" id="heading-3">
							            <h2 class="card-title">
							                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                                Menambah Keranjang
							                </a>
							            </h2>
							        </div><!-- End .card-header -->
							        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-1">
							            <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Pilih Menu Akun.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Setelah itu masukkan username dan password yang sudah didaftarkan. Lalu tekan masuk.
                                                </li>
                                                <li class="list-group-item">
                                                    3. Setelah di halaman utama, pilih produk yang ingin dimasukkan ke dalam keranjang.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Setelah itu pilih kuantitas barang yang ingin ditambahkan. Lalu pilih tombol add to cart.
                                                </li>
                                                <li class="list-group-item">
                                                    5. Setelah itu, produk yang dipilih akan tampil di keranjang.
                                                </li>
                                                <li class="list-group-item">
                                                    6. Maka akan muncul harga barang dan list barang, dan juga button hapus keranjang.
                                                </li>
                                                <li class="list-group-item">
                                                    7. Klik Checkout untuk melihat total harga pembelian (harga barang + ongkos kirim).
                                                </li>
                                                <li class="list-group-item">
                                                    8. Setelah Meng-klik Checkout maka akan Menampilkan Jumlah Produk , alamat (kebutuhan pada ongkos kirim) , Total keseluruhan pembelian barang.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
							        </div><!-- End .collapse -->
							    </div><!-- End .card -->

                                <div class="card card-box card-sm bg-light">
							        <div class="card-header" id="heading-4">
							            <h2 class="card-title">
							                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                                Menghapus Keranjang
							                </a>
							            </h2>
							        </div><!-- End .card-header -->
							        <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-1">
							            <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Melihat produk apa saja yang telah kita masukkan ke dalam keranjang.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Maka akan muncul harga barang dan list barang, dan juga button hapus keranjang
                                                </li>
                                                <li class="list-group-item">
                                                    3. Klik tanda X, untuk Menghapus produk dari keranjang.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Produk Berhasil di hapus dari keranjang.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
							        </div><!-- End .collapse -->
							    </div><!-- End .card -->
                                
                                <div class="card card-box card-sm bg-light">
							        <div class="card-header" id="heading-5">
							            <h2 class="card-title">
							                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                                Membuat Pesanan
							                </a>
							            </h2>
							        </div><!-- End .card-header -->
							        <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-1">
							            <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Pilih Menu Akun.</li>
                                                <li class="list-group-item">
                                                    2. Setelah itu masukkan username dan password yang sudah didaftarkan. Lalu tekan masuk.
                                                </li>
                                                <li class="list-group-item">
                                                    3. Setelah di halaman utama, pilih produk yang ingin dimasukkan ke dalam keranjang.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Setelah itu pilih kuantitas barang yang ingin ditambahkan. Lalu pilih tombol beli.
                                                </li>
                                                <li class="list-group-item">
                                                    5. Lalu selanjutnya klik button Checkout.
                                                </li>
                                                <li class="list-group-item">
                                                    6. Selanjutnya Masuk ke halaman Cart Total terdiri dari total harga produk yang kita beli dan Jangan
                                                    lupa untuk mengisi Alamat.
                                                </li>
                                                <li class="list-group-item">
                                                    7. Terdapat Button kembali yang berfungsi untuk kembali ke halaman sebelumnya yaitu halaman Checkout.
                                                </li>
                                                <li class="list-group-item">
                                                    8. Klik Lanjutkan Pembelian, maka akan masuk ke halaman Pesanan Anda, dimana halaman tersebut berisi informasi 
                                                    seperti Nama Toko, Jumlah yang di beli dan Jejak Pembelian.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
							        </div><!-- End .collapse -->
							    </div><!-- End .card -->
                                
                                <div class="card card-box card-sm bg-light">
							        <div class="card-header" id="heading-6">
							            <h2 class="card-title">
							                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-6" aria-expanded="false" aria-controls="collapse-6">
                                                Membayar Pesanan
							                </a>
							            </h2>
							        </div><!-- End .card-header -->
							        <div id="collapse-6" class="collapse" aria-labelledby="heading-6" data-parent="#accordion-1">
							            <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Pilih Menu Akun.</li>
                                                <li class="list-group-item">
                                                    2. Setelah itu masukkan username dan password yang sudah didaftarkan. Lalu tekan masuk.
                                                </li>
                                                <li class="list-group-item">
                                                    3. Setelah di halaman utama, pilih menu akun kembali.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Setelah itu Klik Pesananku, lalu klik pesanan yang telah kita buat.
                                                </li>
                                                <li class="list-group-item">
                                                    5. Masukkan Bukti Foto Pembayaran yang sudah dilakukan sesuai dengan Nomor Rekening yang tertera, Lalu kirim.
                                                </li>
                                                <li class="list-group-item">
                                                    6. Selanjutnya Menunggu konfirmasi dari pihak Toko/Admin.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
							        </div><!-- End .collapse -->
							    </div><!-- End .card -->

							</div><!-- End .accordion -->
                		</div><!-- End .col-md-6 -->
                	</div><!-- End .row -->

                </div><!-- .End .tab-pane -->

                <div class="tab-pane fade" id="panduan_penjual" role="tabpanel" aria-labelledby="tab_panduan_penjual">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="accordion" id="accordion-2">

                                <div class="card card-box card-sm bg-light">
                                    <div class="card-header" id="heading-1">
                                        <h2 class="card-title">
                                            <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                                Langkah Pembuatan Akun
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Pilih menu Akun
                                                </li>
                                                <li class="list-group-item">
                                                    2. Setelah itu akan muncul tampilan yang berisi tab masuk dan daftar. Lalu pilih tab Daftar.
                                                </li>
                                                <li class="list-group-item">
                                                    3. Setelah itu akan muncul form untuk mengisi data diri. Pada halaman ini anda diharuskan mengisi nama, username atau nama pengguna, akun email, password akun, jenis kelamin, tanggal lahir dan nomor telepon.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Setelah itu, centang pilihan mengenai kebijakan privasi.
                                                </li>
                                                <li class="list-group-item">
                                                    5. Selanjutnya tekan tombol daftar.
                                                </li>
                                                <li class="list-group-item">
                                                    6. Setelah terdaftar, pengguna akan diarahkan ke halaman utama.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .card -->

                                <div class="card card-box card-sm bg-light">
                                    <div class="card-header" id="heading-2">
                                        <h2 class="card-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                Autentikasi Login
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Pilih Menu Akun.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Setelah itu masukkan username dan password yang sudah didaftarkan. Lalu tekan masuk.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .card -->

                                <div class="card card-box card-sm bg-light">
                                    <div class="card-header" id="heading-3">
                                        <h2 class="card-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                                Mendaftarkan Toko
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Untuk menambahkan akun baru penjual perlu memiliki akun yang sudah didaftarkan pada register atau langsung login juga sudah memiliki akun.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Setelah login, penjual memilih menu akun.
                                                </li>
                                                <li class="list-group-item">
                                                    3. Lalu penjual memilih submenu Toko, lalu menekan tombol isi Data.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Setelah itu akan ditampilkan formulir untuk tempat mengupload foto KTP dan foto selfie dengan memegang KTP. Lalu tekan tombol kirim.
                                                </li>
                                                <li class="list-group-item">
                                                    5. Setelah menekan tombol kirim, maka admin akan melakukan konfirmasi terhadap kebenaran data. Pada halaman penjualan tampil seperti ini.
                                                </li>
                                                <li class="list-group-item">
                                                    6. Jika admin sudah mengkonfirmasi, maka halaman penjual akan  menampilkan informasi seperti berikut.
                                                </li>
                                                <li class="list-group-item">
                                                    7. Selanjutnya, penjual akan diarahkan untuk mengisi data rekening dengan menekan tombol isi data rekening.
                                                </li>
                                                <li class="list-group-item">
                                                    8. Penjual memilih bank yang tersedia.
                                                </li>
                                                <li class="list-group-item">
                                                    9. Lalu penjual memasukan nomor rekening bank.
                                                </li>
                                                <li class="list-group-item">
                                                    10. Penjual memasukkan nama pemilik rekening.
                                                </li>
                                                <li class="list-group-item">
                                                    11. Setelah mengisi data dan memastikan data benar, penjual menekan tombol kirim.
                                                </li>
                                                <li class="list-group-item">
                                                    12. Penjual akan dialihkan ke halaman deskripsi toko. Lalu mengisi nama toko.
                                                </li>
                                                <li class="list-group-item">
                                                    13. Penjual mengisi deskripsi toko yang berisi penjelasan singkat mengenai toko.
                                                </li>
                                                <li class="list-group-item">
                                                    14. Penjual menambahkan foto toko sebagai identitas toko.
                                                </li>
                                                <li class="list-group-item">
                                                    15. Lalu penjual menekan tombol tambah.
                                                </li>
                                                <li class="list-group-item">
                                                    16. Setelah itu akan muncul pemberitahuan bahwa toko menunggu verifikasi dari admin.
                                                </li>
                                                <li class="list-group-item">
                                                    17. Setelah toko diverifikasi, maka akan langsung diarahkan untuk memasukkan password akun. Password yang dimaksud adalah password yang sama dengan password ketika mendaftar akun.
                                                </li>
                                                <li class="list-group-item">
                                                    18. Setelah itu, maka tampilan profil toko selesai dibuat.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .card -->

                                <div class="card card-box card-sm bg-light">
                                    <div class="card-header" id="heading-4">
                                        <h2 class="card-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                                Mendaftarkan Produk
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Untuk menambahkan produk yang akan dijual, pengguna harus sudah login, kemudian memilih menu akun.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Lalu memilih menu toko
                                                </li>
                                                <li class="list-group-item">
                                                    3. Lalu memasukkan password. Password yang dimaksud adalah password yang sama dengan password ketika mendaftar akun.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Lalu menekan tombol masuk
                                                </li>
                                                <li class="list-group-item">
                                                    5. Setelah itu memilih menu produk
                                                </li>
                                                <li class="list-group-item">
                                                    6. Setelah itu menekan tombol tambah produk
                                                </li>
                                                <li class="list-group-item">
                                                    7. Setelah itu memilih kategori produk yang ingin ditambahkan ke dalam toko.
                                                </li>
                                                <li class="list-group-item">
                                                    8. Setelah memilih kategori, maka akan diarahkan ke halaman formulir pengisian. Isian yang diperlukan yaitu nama produk, deskripsi singkat produk, harga, gambar produk, lalu berat.
                                                </li>
                                                <li class="list-group-item">
                                                    9. Lalu penjual menekan tombol kirim.
                                                </li>
                                                <li class="list-group-item">
                                                    10. Setelah itu, penjual menekan menu produk, dan produk akan tampil di sana.
                                                </li>
                                            </ol>
                                        </div><!-- End .card-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .card -->
                                
                                <div class="card card-box card-sm bg-light">
                                    <div class="card-header" id="heading-5">
                                        <h2 class="card-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
                                                Melihat Pesanan Pelanggan
                                            </a>
                                        </h2>
                                    </div><!-- End .card-header -->
                                    <div id="collapse-5" class="collapse" aria-labelledby="heading-5" data-parent="#accordion-2">
                                        <div class="card-body">
                                            <ol class="list-group list-group-numbered">
                                                <li class="list-group-item">
                                                    1. Untuk melihat pesanan pelanggan, pengguna harus sudah login, kemudian memilih menu akun.
                                                </li>
                                                <li class="list-group-item">
                                                    2. Lalu memilih menu toko.
                                                </li>
                                                <li class="list-group-item">
                                                    3. Lalu memasukkan password. Password yang dimaksud adalah password yang sama dengan password ketika mendaftar akun.
                                                </li>
                                                <li class="list-group-item">
                                                    4. Lalu menekan tombol masuk.
                                                </li>
                                                <li class="list-group-item">
                                                    5. Setelah itu memilih menu pembelian.
                                                </li>
                                                <li class="list-group-item">
                                                    6. Maka akan ditampilkan pesanan pelanggan yang memesan barang dari toko.
                                                </li> 
                                            </ol>
                                        </div><!-- End .card-body -->
                                    </div><!-- End .collapse -->
                                </div><!-- End .card -->

                            </div><!-- End .accordion -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                    
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .form-tab -->
        </div>
    </div>
</main>


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection