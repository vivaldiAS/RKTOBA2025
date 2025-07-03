<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    //
    public function model()
    {
        $model = DB::table("history_models")->orderBy("active_date", "DESC")->paginate(20);
        return view("admin.chatbot_model", ["data" => $model]);
    }

    public function dataset()
    {
        $dataset = DB::table("question_answers")->orderBy("created_at", "DESC")->paginate(20);
        return view("admin.chatbot_dataset", ["data" => $dataset]);
    }

    public function addDataset()
    {
        return view("admin.chatbot_add_dataset");
    }

    public function postAddDataset(Request $request){
        $answer = $request->post("answer");
        $questions = $request->post("questions");
        $count = 0;
        $data = [];
        foreach ($answer as $a){
            $data[] = [
                "question" => $questions[$count],
                "answers" => $a
            ];
            $count += 1;
        }
        DB::table("question_answers")->insert($data);
        return redirect("/admin/chatbot/dataset");
    }
}
