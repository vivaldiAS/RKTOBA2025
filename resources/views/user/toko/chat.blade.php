@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

<style>
    textarea.form-control{
        max-height: 45px;
        padding: 0px 15px;
        margin: 0px;
        box-sizing: border-box;
        border: 1px solid rgba(0, 0, 0, 0.250);
        border-radius: 2px;
        resize: none;
    }

    textarea::-webkit-scrollbar{
        display: none;
    }

    button{
        height: 45px;
    }
    
    #chatbox{
        height:375px;
        overflow: auto;
    }

    #sender{
        padding:0px 10px 0px 10px;
        background-color:#F15743;
        border-radius:5px;
        width:max-content;
        max-width: 100%;
        word-wrap: break-word;
    }

    #recipient{
        padding:0px 10px 0px 10px;
        background-color:#805A5A;
        border-radius:5px;
        width:max-content;
        max-width: 100%;
        word-wrap: break-word;
    }

    .chat_text{
        color: #FFFFFF;
        line-height: normal;
    }
</style>

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-dashboard-link">
    <div class="row">

        <div class="col-lg-4">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <h5 class="text-muted mb-0"><span style="color: #F15743;">Jumlah Transaksi</span></h5>
                </div>
            </div> -->

            <!-- <div class="mb-2"></div> -->
            
            <div class="row" style="height:100px; overflow: auto; white-space: nowrap;">
                <div class="col-lg-12">
                    @if($count_ready_chat > 0)
                        @foreach($ready_chat as $ready_chat)
                        <div class="card card-dashboard" style="margin-bottom:8px">
                            <div class="card-body" align="center" style="padding: 0px;">
                                <a href="../chat/{{$ready_chat->id}}" style="font-weight: bold;">{{$ready_chat->username}}</a><br>
                                <!-- <a style="font-size:15px; font-weight: bold;">Pesanan Sedang Berlangsung</a><br>
                                <a style="font-size:25px;">-</a> -->
                            </div><!-- End .card-body -->
                        </div><!-- End .card-dashboard -->
                        @endforeach
                    @else
                        Tidak ada obrolan tersedia
                    @endif
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
            
        </div><!-- .End .tab-pane -->

        <div class="col-lg-8">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <h5 class="text-muted mb-0"><span style="color: #F15743;">Pemberitahuan</span></h5>
                </div>
            </div> -->

            <!-- <div class="mb-2"></div> -->

            @if($id)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            @if($get_toko)
                                <a>{{$user->username}}</a>
                            @endif

                            <hr>

                            <div id="chatbox" style="height:375px; overflow: auto;">
                            @foreach($chatting as $chatting)
                                @if($get_toko)
                                    @if($chatting->id_from == $get_toko  && $chatting->pengirim == "merchant")
                                    <div class="sender_box" align="right">
                                        <div id="sender">
                                            <p align="right" class="chat_text">{{$chatting->isi_chat}}</p>
                                        </div>
                                    </div>
                                        
                                    @elseif($chatting->id_to == $get_toko && $chatting->pengirim == "user")
                                    <div class="recipient_box" align="left">
                                        <div id="recipient">
                                            <p class="chat_text">{{$chatting->isi_chat}}</p>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                            </div>
                            
                            <form action="../chat/{{$id}}/PostChatting" method="post">
                            @csrf
                                <div class="input-group">
                                    <textarea name="isi_chat" class="form-control" placeholder="Tulis Pesan" style="min-height: 0px; margin:0;" required></textarea>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary" type="submit" style="min-width: 0; background-color:#F15743">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                            </svg>
                                        </button>
                                    </div><!-- .End .input-group-appex  nd -->
                                </div><!-- .End .input-group -->

                            </form>
                        </div><!-- End .card-body -->
                    </div><!-- End .card-dashboard -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- .End .tab-pane -->
        
        @elseif(!$id)
        <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <center>Selamat datang di fitur Chat</center>
                        </div><!-- End .card-body -->
                    </div><!-- End .card-dashboard -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- .End .tab-pane -->
        @endif

    </div><!-- End .row -->
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection