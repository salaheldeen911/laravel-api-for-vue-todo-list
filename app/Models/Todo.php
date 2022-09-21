<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    public $fillable = ['body', 'done', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserTodos($query)
    {
        return $query->where('user_id', auth()->user()->id)->orderBy('id', 'ASC');
    }
}
