<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
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
}