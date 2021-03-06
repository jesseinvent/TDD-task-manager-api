<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id'];

    public function completed ()
    {
      // '!!' indicates to return Boolean base on result
       return !!$this->completedTask()->where('task_id', $this->id)->count();
    }

    public function completed_at () {
      if ($this->completed()) {
        return $this->completedTask()->first()->created_at;
      }
      return false;
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }


    public function completedTask()
    {
      return $this->hasOne(CompletedTask::class);
    }
}
