<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    use HasFactory;
    protected $fillable = [
        'form_id',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'id', 'form_id');
    }

    public function answers()
    {
        return $this->hasMany(SessionAnswers::class,'session_id');
    }
}
