<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailMessage;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(){

        $details = [
           'title' => 'Mail from websitepercobaan.com',
           'body' => 'This is for testing email using smtp'
           ];
          
           \Mail::to('jr.siallagan@gmail.com')->send(new \App\Mail\MailMessage($details));
          
           dd("Email sudah terkirim.");
       
        }
}
