<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Config;
use Midtrans\Snap;

use App\Models\Mobil;
use App\Http\Requests\StoreMobilRequest;
use App\Http\Requests\UpdateMobilRequest;
use App\Models\PemesananRental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Session;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //FUNCTION TAMBAH MOBIL RENTAL BARU-EXPERIENCE
    public function PostTambahMobil(Request $request, $kategori_produk_id)
    {
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMobilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $toko = Session::get('toko');
        $validatedData = $request->validate([
            'nama' => 'required',
            'nomor_polisi' => 'required',
            'warna' => 'required',
            'kapasitas_penumpang' => 'required|numeric',
            'harga_sewa_per_hari' => 'required|numeric',
            'service_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        // Upload images and store their filenames in the database
        $imageNames = [];
        if ($request->hasFile('service_image')) {
            foreach ($request->file('service_image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('asset/Image/rental_image'), $imageName);
                $imageNames[] = $imageName;
            }
        }

        $gambar = implode(",", $imageNames);

        Mobil::create([
            'nama' => $request->nama,
            'gambar' => $gambar,
            'nomor_polisi' => $request->nomor_polisi,
            'warna' => $request->warna,
            'mode_transmisi' => $request->mode_transmisi,
            'tipe_driver' => $request->tipe_driver,
            'lokasi' => $request->lokasi,
            'kapasitas_penumpang' => $request->kapasitas_penumpang,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari,
            'merchant_id' => $toko
        ]);

        return redirect("/rental/list_mobil")
            ->with('success', 'Rental car created successfully.');
    }

    public function pesanMobil($id) {
        $mobil = Mobil::find($id);

        return view('user.rental.pesan_mobil', compact('mobil'));
    }

    public function pesanMobilStore(Request $request, $id) {
        $user_id = Auth::user()->id;
        $mobil = Mobil::find($id);

        $request->validate([
            'tanggal_mulai_sewa' => 'required',
            'tanggal_akhir_sewa' => 'required',
            'total_price' => 'required'
        ]);

        $start_date = Carbon::createFromFormat('Y-m-d', $request->tanggal_mulai_sewa);
        $end_date = Carbon::createFromFormat('Y-m-d', $request->tanggal_akhir_sewa);

        $jumlah_hari = $end_date->diffInDays($start_date);

        $pemesanan = PemesananRental::create([
            'tanggal_pemesanan' => Date::now(),
            'tanggal_mulai_sewa' => $request->tanggal_mulai_sewa,
            'tanggal_akhir_sewa' => $request->tanggal_akhir_sewa,
            'jumlah_hari_sewa' => $jumlah_hari,
            'user_id' => $user_id,
            'mobil_id' => $mobil->id,
            'total_harga' => $request->total_price
        ]);

        return redirect()->route('pembayaran.rental', $pemesanan->id)->with('sukses', 'Berhasil melakukan pemesanan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    // public function show(Mobil $mobil)
    // {
    //     //
    // }

    public function pembayaranRental($id)
    {
        $pemesanan = PemesananRental::find($id);

        // dd($pemesanan->id);

        return view('user.rental.pembayaran', compact('pemesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMobilRequest  $request
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'nomor_polisi' => 'required',
            'warna' => 'required',
            'kapasitas_penumpang' => 'required|numeric',
            'harga_sewa_per_hari' => 'required|numeric',
            'service_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $mobil = Mobil::find($id);
        $imageNames = $mobil->gambars();

        if ($request->hasFile('service_image')) {
            // Upload images and update their filenames in the database
            foreach ($request->file('service_image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('asset/Image/rental_image'), $imageName);
                $imageNames[] = $imageName;
            }
        }

        $gambar = implode(",", $imageNames);

        $mobil->nama = $request->nama;
        $mobil->gambar = $gambar;
        $mobil->nomor_polisi = $request->nomor_polisi;
        $mobil->warna = $request->warna;
        $mobil->mode_transmisi = $request->mode_transmisi;
        $mobil->tipe_driver = $request->tipe_driver;
        $mobil->lokasi = $request->lokasi;
        $mobil->kapasitas_penumpang = $request->kapasitas_penumpang;
        $mobil->harga_sewa_per_hari = $request->harga_sewa_per_hari;
        $mobil->save();

        return redirect("/rental/list_mobil")
            ->with('success', 'Rental car updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mobil  $mobil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mobil $mobil)
    {
        //
    }

    public function proccess(Request $request)
    {

        $code = "Mobil-" . mt_rand(000, 999);
        // $coba = (int)  $request->total_harga;
        // dd($coba);


        \Midtrans\Config::$serverKey = 'SB-Mid-server-C59onsDTd32ztIrA981olhiB';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = env('MIDTRANS_ID_3DS');

        // buat array midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int)  $request->total_harga
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email
            ],
            // 'enabled_payments' => [
            //     'gopay', 'bni_va', 'bank_transfer', 'bri_va', 'indomaret', 'alfamart',
            // ],
            "enabled_payments" => [
                "credit_card",
                "permata_va",
                "bca_va",
                "bni_va",
                "bri_va",
                "echannel",
                "other_va",
                "danamon_online",
                "mandiri_clickpay",
                "cimb_clicks",
                "bca_klikbca",
                "bca_klikpay",
                "bri_epay",
                "xl_tunai",
                "indosat_dompetku",
                "kioson",
                "Indomaret",
                "alfamart",
                "akulaku"
            ],
            'vtweb' => []
        ];
        try {

            $paymentUrl = \Midtrans\Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function cancelRental($id)
    {
        $pesanan = PemesananRental::find($id);

        $pesanan->delete();

        return redirect()->route('experience.index');
    }
}
