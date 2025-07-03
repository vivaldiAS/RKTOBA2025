<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CarouselController extends Controller
{
     public function getCarousels()
    {
        // Mengambil data carousel dari tabel 'carousels'
        $carousels = DB::table('carousels')->get([
            'id', 
            'carousel_image', 
            'link_carousel', 
            'open_in_new_tab'
        ]);

        // Mengembalikan data dalam format JSON
        return response()->json($carousels);
    }
}
