<?php

namespace App\Http\Controllers;

use App\Models\TiketExperience;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

class TiketController extends Controller
{
    //
    // function landing page untuk tiket museum kaldera
    public function landing_tiketmuseum()
    {
        $tickets = TiketExperience::all();

        return view('user.tiket.index', compact('tickets'));
    }

    public function  detailtiket()
    {


        return view('user.tiket.detail');
    }


    public function  pembayaran()
    {

        return view('user.tiket.pembayaran');
    }

    public function indexAdmin()
    {
        $tickets = TiketExperience::all();

        return view('user.tiket.index_admin', compact('tickets'));
    }
}
