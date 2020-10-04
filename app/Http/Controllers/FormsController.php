<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use App\Models\SessionAnswers;
use App\Models\Sessions;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view("forms.index", ['forms'=>(Form::orderBy("created_at", "desc")->get())]);
    }

    public function preview($id) {
        $formId = Sessions::find($id)->form_id;
        $questions= Question::all()->where('form_id', $formId)->values();
        return view('game.preview', ['questions'=>$questions, 'session_id'=>$id]);
    }

    public function newSession($id) {
        $session = Sessions::create([
            'form_id' => $id
        ]);
        return redirect('/preview/'.$session->id);
    }

    public  function saveSeleted(Request $request){
        $sessionId = $request[1];
        SessionAnswers::create([
            'question_id' => $request[0]['id'],
            'question_title' => $request[0]['title'],
            'session_id' =>$sessionId,
            'status'=> false,
            'duration'=> $request[0]['duration']
        ]);
        return "hello world";
    }
    public function fetch(){
        $sessionId = \request()->get("session_id");
        $scoreAsText = $this->getScore($sessionId);
        $lastSelected= SessionAnswers::where('session_id', $sessionId)->latest('created_at')->first();
        $lastSelected["scoreAsText"] = $scoreAsText;
        return response()->json($lastSelected);
    }

    public function fetchQuestions($session_id) {
        $session_questions = SessionAnswers::all()->where('session_id', $session_id)->pluck('question_id');
        $response = Question::all()->where('form_id', Sessions::find($session_id)->form_id)->whereNotIn('id', $session_questions);
        return $response->values();
    }

    public function updateStatus(Request $request) {
        $question = SessionAnswers::where('question_id', $request->id)->latest()->first();
        $question->status  = $request->item['status'];
        $question->save();
        return response()->json($question);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate(['name'=>'string', 'description'=>'string']);
        Form::create($validate);
        return redirect('/form')->with('success', 'تم اضافة النموذج بنجاح')->with("created", "true");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $forms
     * @return \Illuminate\Http\Response
     */
    public function show(Form $forms)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Form  $forms
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        preg_match('/form\/(.+?)\//', \request()->getPathInfo(), $result);
        $form = Form::find($result[1]);
        $questions = Question::all()->where("form_id", $form->id);
        return view('forms.edit', ['form'=>$form, 'questions'=>$questions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $forms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $forms = Form::find($request->id);
        $validated = $request->validate(['name'=>'string', 'description'=>'string']);
        $forms->name = $validated['name'];
        $forms->description = $validated['description'];
        $forms->save();
        return back()->with("success", "تم تحديث بيانات هذا النموذج");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $forms
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        Form::find(request('id'))->delete();
        return back()->with("success", "تم الحذف بنجاح");
    }

    public function getScore($session_id) {
        $form = Sessions::find($session_id)->form_id;
        $answers = sizeof(Question::all()->where('form_id', $form));
        $count_answers_true = sizeof(SessionAnswers::all()->where('session_id', $session_id)->where('status', 1));
        $text = "التحصيل: ";
        $text .= $count_answers_true;
        $text .= " من ";
        $text .= "$answers";
        return $text;
    }
}
