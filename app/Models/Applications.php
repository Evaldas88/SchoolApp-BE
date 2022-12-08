<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{use HasFactory;
    protected $fillable = [
        'approved', 'student_id', 'class', 'name', 'surname', 'student_bd'
    ];

    public function schools()
    {
        return $this->belongsTo(Schools::class);
    }
}