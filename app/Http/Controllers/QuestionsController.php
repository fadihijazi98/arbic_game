<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        Question::create($validated);
        return redirect('/form/'.$validated['form_id'].'/edit?');
    }

    public function update(Request $request)
    {
        $validated = $this->validateRequest($request);
        $question = Question::find($validated['id']);
        $question->title = $validated['title'];
        $question->content = $validated['content'];
        $question->duration = $validated['duration'];
        $question->save();

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        Question::find($request->id)->delete();
        return back();
    }

    public function validateRequest(Request $request)
    {
        return $request->validate(['id'=>'sometimes|integer', 'title'=>'string|max:60', 'content'=>'string', 'duration'=>'integer|min:5|max:60', 'form_id'=>'integer']);
    }

}
