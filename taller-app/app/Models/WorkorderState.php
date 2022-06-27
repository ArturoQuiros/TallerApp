<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkorderState extends Model
{
    use HasFactory;
    protected $fillable = ['description', 'is_active'];
}
