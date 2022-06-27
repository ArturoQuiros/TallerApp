<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = ['workorder_id','link'];

    public function Workorder()
    {
        return $this->belongsTo(Workorder::class);
    }


}
