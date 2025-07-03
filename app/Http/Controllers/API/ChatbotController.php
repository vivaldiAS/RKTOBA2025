<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    private function formatRupiah($money)
    {
        return "Rp. " . number_format($money, 2, ',', '.');
    }

    private function nullResponse(){
        return [
            "answer"=> "Maaf data yang anda cari tidak ada tersimpan pada database kami"
        ];
    }

    //
    public function detailProduct(Request $request)
    {
        $product_name = $request->post("product_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
                "product_description",
                "price",
                "heavy",
                "nama_kategori",
                "nama_merchant"
            )
            ->join("merchants as m", "m.merchant_id", "=", "p.merchant_id")
            ->join("categories as c", "c.category_id", "=", "p.category_id")
            ->whereRaw("MATCH(product_name) AGAINST ('${product_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }

        $format_money = $this->formatRupiah($data->price);
        $answer = "$data->product_name merupakan salah satu produk yang dijual oleh $data->nama_merchant "
            ."produk ini masuk dalam kategori $data->nama_kategori.".
            " Produk ini memiliki berat $data->heavy gram, produk ini dihargai dengan harga $format_money. $data->product_description";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function productPrice(Request $request)
    {
        $product_name = $request->post("product_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
                "price",
            )
            ->whereRaw("MATCH(product_name) AGAINST ('${product_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $format_money = number_format($data->price);
        $answer = "Harga yang diberikan untuk $data->product_name adalah sebesar Rp. $format_money";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function productStock(Request $request)
    {
        $product_name = $request->post("product_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
                "stok",
            )
            ->join("stocks as s", "s.product_id", "=", "p.product_id")
            ->whereRaw("MATCH(product_name) AGAINST ('${product_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Stok yang tersedia untuk $data->product_name adalah sebesar $data->stok";
        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function descProduct(Request $request)
    {
        $product_name = $request->post("product_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
                "product_description",
            )
            ->whereRaw("MATCH(product_name) AGAINST ('${product_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Produk $data->product_name $data->product_description";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function allCategory()
    {
        $data = DB::table("categories", )
            ->select(
                "nama_kategori",
            )
            ->get();

        if(count($data) === 0){
            return response()->json($this->nullResponse());
        }
        $answer = "Kategori kategori yang tersedia di rumah kreatif toba adalah sebagai berikut: <br>";
        $count = 1;
        foreach ($data as $d){
            $answer.= "$count. $d->nama_kategori<br>";
            $count += 1;
        }
        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function totalProductSale(Request $request)
    {
        $product_name = $request->post("product_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
            )
            ->selectRaw("SUM(jumlah_pembelian_produk) as total_sale")
            ->join("product_purchases as pp", "pp.product_id" , "=", "p.product_id")
            ->whereRaw("MATCH(product_name) AGAINST ('${product_name}' IN NATURAL LANGUAGE MODE)")
            ->groupBy("product_name")
            ->orderBy("total_sale", "DESC")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Produk $data->product_name sudah terjual sebanyak $data->total_sale kali";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function bestProductSale(Request $request)
    {
        $store_name = $request->post("store_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
                "nama_merchant"
            )
            ->selectRaw("COUNT(pp.product_id) as total_sale")
            ->join("product_purchases as pp", "pp.product_id" , "=", "p.product_id")
            ->join("merchants as m", "m.merchant_id", "=", "p.merchant_id")
            ->whereRaw("MATCH(nama_merchant) AGAINST ('${store_name}' IN NATURAL LANGUAGE MODE)")
            ->groupBy("product_name", "nama_merchant")
            ->orderBy("total_sale", "DESC")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Produk paling banyak dibeli di toko $data->nama_merchant adalah $data->product_name dengan total penjualan sebanyak $data->total_sale";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function detailStore(Request $request)
    {
        $store_name = $request->post("store_name", "");

        $data = DB::table("merchants", "m")
            ->select(
                "nama_merchant",
                "deskripsi_toko",
                "kontak_toko",
                "username"
            )
            ->selectRaw("COUNT(p.product_id) as total_product")
            ->join("users as u", "u.id", "=", "m.user_id")
            ->join("products as p", "p.merchant_id", "=", "m.merchant_id")
            ->whereRaw("MATCH(nama_merchant) AGAINST ('${store_name}' IN NATURAL LANGUAGE MODE)")
            ->groupBy("nama_merchant", "deskripsi_toko", "kontak_toko", "username")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Toko $data->nama_merchant dimiliki oleh $data->username,"
        . " toko ini dapat anda hubungi melalui $data->kontak_toko, "
        . "toko  ini memiliki $data->total_product jenis produk untuk dijual. Toko ini $data->deskripsi_toko";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function addressStore(Request $request)
    {
        $store_name = $request->post("store_name", "");

        $data = DB::table("merchants", "m")
            ->select(
                "nama_merchant",
                "province_name",
                "city_name",
                "subdistrict_name",
                "merchant_street_address"
            )
            -> join("merchant_address as ma", "ma.merchant_id", "=", "m.merchant_id")
            ->whereRaw("MATCH(nama_merchant) AGAINST ('${store_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Toko $data->nama_merchant beralamatkan di $data->province_name"
            . ", $data->city_name,  $data->subdistrict_name, $data->merchant_street_address";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function phoneNumberStore(Request $request)
    {
        $store_name = $request->post("store_name", "");

        $data = DB::table("merchants", "m")
            ->select(
                "nama_merchant",
                "kontak_toko"
            )
            ->whereRaw("MATCH(nama_merchant) AGAINST ('${store_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Anda dapat menghubungi toko $data->nama_merchant melalui nomor $data->kontak_toko";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function descStore(Request $request)
    {
        $store_name = $request->post("store_name", "");

        $data = DB::table("merchants", "m")
            ->select(
                "nama_merchant",
                "deskripsi_toko"
            )
            ->whereRaw("MATCH(nama_merchant) AGAINST ('${store_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Toko $data->nama_merchant $data->deskripsi_toko";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function availableVoucher()
    {
        $data = DB::table("vouchers", "v")
            ->select(
                "nama_voucher",
                "tipe_voucher",
                "potongan",
                "minimal_pengambilan",
                "maksimal_pemotongan",
                "tanggal_berlaku",
                "tanggal_batas_berlaku"
            )
            ->whereDate("tanggal_berlaku", "<=", now())
            ->whereDate("tanggal_batas_berlaku", ">=", now())
            ->get();

        if(count($data) === 0){
            return response()->json(
                [
                    "answer" => "Tidak ada voucher aktif sekarang",
                ]
            );
        }
        $answer = "Terdapat beberapa voucher yang dapat anda gunakan di rumah kreatif toba<br>";
        $count = 1;
        foreach ($data as $d){
            $minimal_format = number_format($d->minimal_pengambilan);
            $maksimal_format = number_format($d->maksimal_pemotongan);
            $answer.= "$count. $d->nama_voucher dengan potongan $d->potongan, dimana voucher ini berlaku untuk"
            . " tipe $d->tipe_voucher. Voucher ini memiliki minimal pembelian Rp. $minimal_format dan batas maksimal potongan Rp. $maksimal_format"
            . ". Voucher ini hanya berlaku pada tanggal $d->tanggal_berlaku sampai dengan $d->tanggal_batas_berlaku<br>";
            $count += 1;
        }

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function specProduct(Request $request)
    {
        $product_name = $request->post("product_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
                "nama_spesifikasi",
                "nama_jenis_spesifikasi"
            )
            ->join("product_specifications as ps", "ps.product_id", "=", "p.product_id")
            ->join("specifications as s", "s.specification_id", "=", "ps.specification_id")
            ->join("specification_types as st", "st.specification_type_id", "=", "s.specification_type_id")
            ->whereRaw("MATCH(product_name) AGAINST ('${product_name}' IN NATURAL LANGUAGE MODE)")
            ->get();

        if(count($data) === 0){
            return response()->json($this->nullResponse());
        }
        $product_name_table = $data[0]->product_name;
        $answer = "Produk $product_name_table memiliki spesifikasi<br>";
        $count = 1;
        foreach ($data as $d){
            $answer .= "$count. ($d->nama_jenis_spesifikasi) $d->nama_spesifikasi<br>";
            $count += 1;
        }
        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function storeOwner(Request $request)
    {
        $store_name = $request->post("store_name", "");

        $data = DB::table("merchants", "m")
            ->select(
                "nama_merchant",
                "username"
            )
            ->join("users as u", "u.id", "=", "m.user_id")
            ->whereRaw("MATCH(nama_merchant) AGAINST ('${store_name}' IN NATURAL LANGUAGE MODE)")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $answer = "Toko $data->nama_merchant dimiliki oleh $data->username";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function ratingProduct(Request $request)
    {
        $product_name = $request->post("product_name", "");

        $data = DB::table("products", "p")
            ->select(
                "product_name",
            )
            ->selectRaw("AVG(nilai_review) as review")
            ->join("reviews as r", "r.product_id", "=", "p.product_id")
            ->whereRaw("MATCH(product_name) AGAINST ('${product_name}' IN NATURAL LANGUAGE MODE)")
            ->groupBy("product_name")
            ->first();

        if($data === null){
            return response()->json($this->nullResponse());
        }
        $rating = number_format($data->review, 0);
        $answer = "Produk dengan nama $data->product_name mendapatkan rarting $rating dari 5";

        return response()->json(
            [
                "answer" => $answer,
            ]
        );
    }

    public function activateModel(Request $request){

        $found = DB::table("fine_tunes")->find($request->post("fine_tune_id"));
        DB::table("history_models")->insert([
            "name"=> $found->name,
            "train_date"=> $found->date_request_at,
            "active_date"=> now(),
            "fine_tune_id"=> $found->id
        ]);

        return response()->json(
            [
                "answer" => "Success",
            ]
        );
    }

    public function fineTuneModel(Request $request){
        $host = env("DB_HOST");
        $user = env("DB_USERNAME");
        $password = env("DB_PASSWORD");
        $port = env("DB_PORT");
        $dbname= env("DB_DATABASE");
        $openApiKey = env("OPENAI_TOKEN");
        $shell_out = shell_exec("python3 asset/js/chatbot.py --open-api-key $openApiKey --host $host --port $port --user $user --password $password --dbname $dbname");
//        DB::table("fine_tunes")->insert([
//            "id"=>$shell_out,
//            "name"=>"TRAINED_MODEL_FROM_PHP",
//            "date_request_at"=>now(),
//            "model_name"=> "trained_model"
//        ]);
        return response()->json(
            [
                "execute" => $shell_out
            ]
        );
    }
}
