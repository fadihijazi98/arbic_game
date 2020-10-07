<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['image_path'];

    public function getImagePathAttribute() {
        $img = DB::table('questions_images')->where('question_id', $this->id)->first();
        return (isset($img->image_path)?$img->image_path:'');
    }
}
