<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use PDF;

class InvoiceController extends Controller
{
    public function invoice_pembelian($purchase_id)
    {
        $user_id = Auth::user()->id;
        
        $profile = DB::table('profiles')->where('user_id', $user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();
                
        $purchases = DB::table('purchases')->where('purchases.user_id', $user_id)->where('purchase_id', $purchase_id)
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();
        
        if($purchases->harga_pembelian == null){
            $total_harga_pembelian = DB::table('product_purchases')->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga_pembelian'))
            ->where('purchases.checkout_id', $purchases->checkout_id)
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();

            $semua_total_harga_pembelian = $total_harga_pembelian->total_harga_pembelian;
        }
  
        else if($purchases->harga_pembelian != null){
            $semua_total_harga_pembelian = $purchases->harga_pembelian;
        }

        $claim_pembelian_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'pembelian')->where('checkout_id', $purchases->checkout_id)->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->first();
        
        $claim_ongkos_kirim_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'ongkos_kirim')->where('checkout_id', $purchases->checkout_id)->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->first();

        $purchases_address = DB::table('user_address')->where('user_id', $purchases->user_id)->first();

        $merchant_purchase = DB::table('product_purchases')->select('merchant_id')->where('purchase_id', $purchase_id)
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->groupBy('merchant_id')->first();

        $cek_merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->count();

        $merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->first();

        $cek_user_address = DB::table('purchases')->where('purchases.user_id', $user_id)->where('purchase_id', $purchase_id)
        ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->count();

        $user_address = DB::table('purchases')->where('purchases.user_id', $user_id)->where('purchase_id', $purchase_id)
        ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->first();

        if($cek_user_address != 0){
            $courier_code = $purchases->courier_code;
            $service = $purchases->service;

            if($courier_code != "" || $service != ""){
                if($courier_code == "pos"){ $courier_name = "POS Indonesia (POS)"; }
                else if($courier_code == "jne"){ $courier_name = "Jalur Nugraha Eka (JNE)"; }
                else if($courier_code == "pengiriman_lokal"){ $courier_name = "Pengiriman Lokal Oleh Toko"; }

                $service_name = $service;
                
                $ongkir = $purchases->ongkir;
            }
            
            else{
                $ongkir = 0;
                $courier_name = "";
                $service_name = "";
            }            
        }

        else if($cek_user_address == 0){
            $lokasi_pembeli = "";
            $ongkir = 0;
            $courier_name = "";
            $service_name = "";
        }

        $merchant = DB::table('product_purchases')->select('nama_merchant', 'kontak_toko')->where('purchases.user_id', $user_id)
        ->where('product_purchases.purchase_id', $purchase_id)
        ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')->first();

        $product_purchases = DB::table('product_purchases')->where('user_id', $user_id)->where('product_purchases.purchase_id', $purchase_id)
        ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->orderBy('product_purchases.product_purchase_id', 'desc')->get();

        $product_specifications = DB::table('product_specifications')
        ->join('products', 'product_specifications.product_id', '=', 'products.product_id')
        ->join('specifications', 'product_specifications.specification_id', '=', 'specifications.specification_id')
        ->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get();

        $cek_proof_of_payment = DB::table('proof_of_payments')->where('purchase_id', $purchase_id)->first();

        return view('user.pembelian.invoice_pembelian', compact(['claim_pembelian_voucher', 'claim_ongkos_kirim_voucher', 'merchant', 'product_purchases', 'purchases', 'semua_total_harga_pembelian', 'product_specifications', 'profile', 'cek_user_address', 'user_address', 'cek_merchant_address', 'merchant_address', 'ongkir', 'courier_name', 'service_name']));

        // $pdf = PDF::loadview('user.pembelian.invoice_pembelian', compact(['claim_pembelian_voucher', 'claim_ongkos_kirim_voucher', 'merchant', 'product_purchases', 'purchases', 'product_specifications', 'profile', 'cek_user_address', 'user_address', 'lokasi_pembeli', 'cek_merchant_address', 'merchant_address', 'lokasi_toko', 'ongkir', 'courier_name', 'service_name']));

    	// return $pdf->download("invoice_pembelian_$purchases->kode_pembelian.pdf");
    }


    public function invoice_penjualan($purchase_id)
    {
        $toko = Session::get('toko');
            
        $cek_purchase = DB::table('purchases')->where('purchase_id', $purchase_id)->where('status_pembelian', 'status2')
        ->join('users', 'purchases.user_id', '=', 'users.id')->first();

        $purchase = DB::table('purchases')->where('purchase_id', $purchase_id)->join('users', 'purchases.user_id', '=', 'users.id')->first();

        $profile = DB::table('profiles')->where('user_id', $purchase->user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();

        $merchant = DB::table('product_purchases')->select('nama_merchant', 'kontak_toko')->where('products.merchant_id', $toko)
        ->where('product_purchases.purchase_id', $purchase_id)
        ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')->first();

        $product_purchases = DB::table('product_purchases')->where('merchant_id', $toko)->where('product_purchases.purchase_id', $purchase_id)
        ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->orderBy('product_purchases.product_purchase_id', 'desc')->get();

        $product_specifications = DB::table('product_specifications')
        ->join('products', 'product_specifications.product_id', '=', 'products.product_id')
        ->join('specifications', 'product_specifications.specification_id', '=', 'specifications.specification_id')
        ->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get();
        
        $total_harga = DB::table('product_purchases')->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga'))
        ->where('product_purchases.purchase_id', $purchase_id)->join('products', 'product_purchases.product_id', '=', 'products.product_id')->first();
        
        $cek_proof_of_payment = DB::table('proof_of_payments')->where('purchase_id', $purchase_id)->first();

        $purchases = DB::table('purchases')->where('purchase_id', $purchase_id)
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();

        $profile = DB::table('profiles')->where('user_id', $purchases->user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();

        $purchases_address = DB::table('user_address')->where('user_id', $purchases->user_id)->first();

        $merchant_purchase = DB::table('product_purchases')->select('merchant_id')->where('purchase_id', $purchase_id)
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->groupBy('merchant_id')->first();

        $cek_merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->count();

        $merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->first();

        $cek_user_address = DB::table('purchases')->where('purchases.user_id', $purchases->user_id)->where('purchase_id', $purchase_id)
        ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->count();

        $user_address = DB::table('purchases')->where('purchases.user_id', $purchases->user_id)->where('purchase_id', $purchase_id)
        ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->first();


        if($cek_user_address != 0){
            $courier_code = $purchases->courier_code;
            $service = $purchases->service;

            if($courier_code != "" || $service != ""){
                if($courier_code == "pos"){ $courier_name = "POS Indonesia (POS)"; }
                else if($courier_code == "jne"){ $courier_name = "Jalur Nugraha Eka (JNE)"; }
                else if($courier_code == "pengiriman_lokal"){ $courier_name = "Pengiriman Lokal Oleh Toko"; }

                $service_name = $service;
                
                $ongkir = $purchases->ongkir;
            }
            
            else{
                $ongkir = 0;
                $courier_name = "";
                $service_name = "";
            }
        }

        else if($cek_user_address == 0){
            $lokasi_pembeli = "";
            $ongkir = 0;
            $courier_name = "";
            $service_name = "";
        }

        return view('user.toko.invoice_penjualan', compact(['merchant', 'product_purchases', 'purchases', 'product_specifications', 'total_harga', 'profile', 'cek_user_address', 'user_address', 'cek_merchant_address', 'merchant_address', 'ongkir', 'courier_name', 'service_name']));

        // $pdf = PDF::loadview('user.toko.invoice_penjualan', compact(['merchant', 'product_purchases', 'purchases', 'product_specifications', 'total_harga', 'profile', 'cek_user_address', 'user_address', 'lokasi_pembeli', 'cek_merchant_address', 'merchant_address', 'lokasi_toko', 'ongkir', 'courier_name', 'service_name']));

    	// return $pdf->download("invoice_penjualan_$purchases->kode_pembelian.pdf");
    }
}
