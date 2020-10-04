<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAnswers extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id','question_title','session_id', 'status','duration'
    ];

    public function sessions()
    {
        return $this->belongsTo(Sessions::class, 'id', 'session_id');
    }
}
