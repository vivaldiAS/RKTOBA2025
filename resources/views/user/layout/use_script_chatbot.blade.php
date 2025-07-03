<!-- <script>
    let botImage = '{{URL::asset('asset/Image/chatbot/bot.png')}}';
    let closeImage = '{{URL::asset('asset/Image/chatbot/close.png')}}';
    let personImage = '{{URL::asset('asset/Image/chatbot/people.png')}}';
    let model = "{{ \Illuminate\Support\Facades\DB::table("history_models")->orderBy("active_date", "DESC")->first()->name  }}";
    console.log(model);
    let token = "{{env('OPENAI_TOKEN')}}";
</script>
<script src="{{ URL::asset('asset/js/chatbot.js')  }}"></script> -->