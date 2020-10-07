<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionsController extends Controller
{

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $question = Question::create($validated);
        //ins
        if (isset($validated['image'])) {
            $imageName = Storage::disk('public')->put('question_images', $validated['image']);
            DB::table('questions_images')->insert([
                'question_id' => $question->id,
                'image_path' => $imageName
            ]);
        }
        return redirect('/form/' . $validated['form_id'] . '/edit?');
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
        $row = DB::table('questions_images')->where("question_id", $request->id)->first();
        if (isset($row)) {
            Storage::disk('public')->delete($row->image_path);
            DB::table('questions_images')->where('question_id', $request->id)->delete();
        }
        Question::find($request->id)->delete();
        return back();
    }

    public function validateRequest(Request $request)
    {
        //ins -> image : mimes ..
        return $request->validate(['id' => 'sometimes|integer', 'title' => 'string|max:60', 'content' => 'string', 'duration' => 'integer|min:5|max:60', 'form_id' => 'integer', 'image' => 'sometimes|mimes:jpeg,png']);
    }

}
