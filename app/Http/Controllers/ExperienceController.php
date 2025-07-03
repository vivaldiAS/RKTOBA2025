<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Mobil;
use App\Models\PemesananRental;
use App\Models\PemesananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ExperienceController extends Controller
{
    public function index()
    {
        return view('user.experience_index');
    }

    public function rental()
    {
        $list_mobil = Mobil::all();

        return view('user.rental.index', compact('list_mobil'));
    }

    public function rental_index()
    {
        $toko = Session::get('toko');
        $pesanan = PemesananRental::with('mobil.merchant')->whereHas('mobil', function ($query) use ($toko) {
            $query->where('merchant_id', $toko);
        })
            ->count();
        $total_mobil = Mobil::where('merchant_id', $toko)->count();

        return view('user.rental.rental_index', compact('pesanan', 'total_mobil'));
    }
    public function view_list_mobil()
    {
        $toko = Session::get('toko');

        $list_mobil = Mobil::where('merchant_id', $toko)->get();
        return view("user.rental.list_mobil", ['list_mobil' => $list_mobil]);
    }

    public function add()
    {
        $user = Auth::user();

        $merchant = $user->merchant;

        return view('user.rental.add', compact('merchant'));
    }

    public function edit($id)
    {
        $user = Auth::user();

        $mobil = Mobil::find($id);

        return view('user.rental.edit', compact('mobil'));
    }

    public function detail($id)
    {
        $user = Auth::user();

        $mobil = Mobil::find($id);

        return view('user.rental.detail', compact('mobil'));
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nama' => 'required',
            'nomor_polisi' => 'required',
            'warna' => 'required',
            'kapasitas_penumpang' => 'required|numeric',
            'harga_sewa_per_hari' => 'required|numeric'
        ]);

        $mobil = Mobil::find($id);

        // Upload images and store their filenames in the database
        if ($request->hasFile('service_image')) {
            $imageNames = [];
            foreach ($request->file('service_image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('asset/Image/rental_image'), $imageName);
                $imageNames[] = $imageName;
            }

            $gambar = implode(",", $imageNames);

            $mobil->update([
                'nama' => $request->nama,
                'gambar' => $gambar,
                'nomor_polisi' => $request->nomor_polisi,
                'warna' => $request->warna,
                'mode_transmisi' => $request->mode_transmisi,
                'tipe_driver' => $request->tipe_driver,
                'lokasi' => $request->lokasi,
                'kapasitas_penumpang' => $request->kapasitas_penumpang,
                'harga_sewa_per_hari' => $request->harga_sewa_per_hari
            ]);

            return redirect("/rental/list_mobil")
                ->with('success', 'Rental car updated successfully.');
        }

        $mobil->update([
            'nama' => $request->nama,
            'nomor_polisi' => $request->nomor_polisi,
            'warna' => $request->warna,
            'mode_transmisi' => $request->mode_transmisi,
            'tipe_driver' => $request->tipe_driver,
            'lokasi' => $request->lokasi,
            'kapasitas_penumpang' => $request->kapasitas_penumpang,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari
        ]);

        return redirect("/rental/list_mobil")
            ->with('success', 'Rental car updated successfully.');
    }

    public function delete($id)
    {
        $mobil = Mobil::find($id);

        $mobil->delete();

        return back()->with('success', 'Rental car deleted successfully');
    }

    public function PesananRental()
    {
        $toko = Session::get('toko');
        $list_pesanan = PemesananRental::with('mobil.merchant')->whereHas('mobil', function ($query) use ($toko) {
            $query->where('merchant_id', $toko);
        })
            ->get();

        return view('user.rental.daftarPesanan', compact('list_pesanan'));
    }

    public function PesananTiket()
    {
        $toko = Session::get('toko');
        $list_pesanan = PemesananTiket::with('tiket_experience.merchant')->whereHas('tiket_experience', function ($query) use ($toko) {
            $query->where('merchant_id', $toko);
        })
            ->get();

        return view('user.tiket.daftarPesanan', compact('list_pesanan'));
    }

    public function detailPesananRental($id)
    {
        $pesanan = PemesananRental::find($id);

        return view('user.rental.detailPesananRental', compact('pesanan'));
    }

    public function detailPesananTiket($id)
    {
        $pesanan = PemesananTiket::find($id);

        return view('user.tiket.detailPesananTiket', compact('pesanan'));
    }

    public function daftarSewaRental()
    {
        $user = Auth::user()->id;
        $pesanan = PemesananRental::where('user_id', $user)->get();

        return view('user.rental.daftarSewaRental', compact('pesanan'));
    }

    public function cariRental(Request $request)
    {
        if ($request->tipe_driver == 'Semua') {
            $list_mobil = Mobil::all();
            return view('user.rental.index', compact('list_mobil'));
        }
        $list_mobil = Mobil::where('tipe_driver', $request->tipe_driver)->get();

        return view('user.rental.index', compact('list_mobil'));
    }
}
