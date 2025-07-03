<?php

namespace App\Http\Controllers;

use App\Models\TiketExperience;
use App\Http\Requests\StoreTiketExperienceRequest;
use App\Http\Requests\UpdateTiketExperienceRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Mobil;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\PemesananTiket;
use Illuminate\Support\Facades\Session;


class TiketExperienceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $user = Auth::user();

        $merchant = $user->merchant;

        return view('user.tiket.add', compact('merchant'));
    }

    public function pesanTiket(Request $request, $id)
    {
        $tiket = TiketExperience::find($id);
        if (!$tiket) {
            return back()->with('gagal', 'Data tidak ditemukan');
        }

        return view('user.tiket.detail', compact('tiket'));
    }

    public function pesanTiketStore(Request $request, $id)
    {

        $user_id = Auth::user()->id;
        $tiket = TiketExperience::find($id);


        // dd($mobil);
        $validator = $request->validate([
            'tanggal_berkunjung' => 'required',
            'jumlah_anak' => 'required',
            'jumlah_dewasa' => 'required',
            'total_harga' => ''
        ]);

        $total_harga = $request->total_harga + ($request->total_harga * 0.05);

        $pemesanan = PemesananTiket::create([
            'tanggal_pemesanan' => $request->tanggal_berkunjung,
            'jumlah_anak' => $request->jumlah_anak,
            'jumlah_dewasa' => $request->jumlah_dewasa,
            'user_id' => $user_id,
            'tiket_experience_id' => $id,
            'total_harga' => $total_harga
        ]);

        // dd($pemesanan);

        return redirect()->route('pembayaran.tiket', $pemesanan->id)->with('sukses', 'Berhasil melakukan pemesanan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTiketExperienceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $toko = Session::get('toko');
        //Validasi input
        $validatedData = $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'jenis_tiket' => 'required',
            'jam_operasional' => 'required',
            'harga_anak' => 'required',
            'harga_dewasa' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('asset/image/tiket_image'), $imageName);
        }

        // Buat objek tiket baru
        $tiket = new TiketExperience;
        $tiket->nama = $request->nama;
        $tiket->lokasi = $request->lokasi;
        $tiket->jenis_tiket = $request->jenis_tiket;
        $tiket->jam_operasional = $request->jam_operasional;
        $tiket->harga_anak = $request->harga_anak;
        $tiket->harga_dewasa = $request->harga_dewasa;
        $tiket->gambar = $imageName;
        $tiket->merchant_id = $toko;
        $tiket->save();

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect("/tiket/admin")->with('success', 'Tiket berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TiketExperience  $tiketExperience
     * @return \Illuminate\Http\Response
     */
    public function show(TiketExperience $tiketExperience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TiketExperience  $tiketExperience
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $tiket = TiketExperience::findOrFail($id);
        return view('user.tiket.update', compact('tiket'));
    }

    public function detail($id)
    {
        $user = Auth::user();

        $tiket = TiketExperience::find($id);

        return view('user.tiket.detailAdmin', compact('tiket'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTiketExperienceRequest  $request
     * @param  \App\Models\TiketExperience  $tiketExperience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'jenis_tiket' => 'required',
            'jam_operasional' => 'required',
            'harga_anak' => 'required',
            'harga_dewasa' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari tiket berdasarkan ID
        $tiket = TiketExperience::findOrFail($id);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('asset/image/tiket_image'), $imageName);

            // Hapus gambar lama jika ada
            if ($tiket->gambar) {
                unlink(public_path('asset/image/tiket_image' . $tiket->gambar));
            }

            $tiket->gambar = $imageName;
        }

        // Update data tiket
        $tiket->nama = $request->nama;
        $tiket->lokasi = $request->lokasi;
        $tiket->jenis_tiket = $request->jenis_tiket;
        $tiket->jam_operasional = $request->jam_operasional;
        $tiket->harga_anak = $request->harga_anak;
        $tiket->harga_dewasa = $request->harga_dewasa;
        $tiket->save();

        // Redirect atau berikan respons sesuai kebutuhan Anda
        return redirect("/tiket/admin")->with('success', 'Data tiket telah berhasil di Update');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TiketExperience  $tiketExperience
     * @return \Illuminate\Http\Response
     */

     public function delete($id)
    {
        $tickets = TiketExperience::all();
        // dd($tiket);
        // Temukan item berdasarkan ID
        $item = PemesananTiket::find($id);

        // Periksa jika item tidak ditemukan
        if (!$item) {
            return view('user.tiket.index', compact('tickets'))->with('error', 'Item not found.');
        }

        // Hapus item
        $item->delete();

        return view('user.tiket.index', compact('tickets'))->with('success', 'Item deleted successfully.');
    }
    public function pembayaranTiket($id)
    {
        $tiket = PemesananTiket::find($id);

        // dd($tiket);
        return view('user.tiket.pembayaran', compact('tiket'));
    }

    public function removeFromCart(Request $request)
    {
        $productId = $request->input('id');

        // Menghapus produk dari keranjang belanja berdasarkan ID produk
        PemesananTiket::remove($productId);

        // Mengembalikan respons atau melakukan redirect ke halaman yang sesuai
        // Sesuaikan dengan kebutuhan Anda
        return redirect()->back();
    }

    public function proccess(Request $request)
    {
        $code = "Tiket-" . mt_rand(000, 999);

        // $coba = (int)  $request->total_harga;

        // dd($code);

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
}
