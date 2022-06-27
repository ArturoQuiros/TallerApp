<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workorder extends Model
{
    use HasFactory;
    protected $fillable = ['client_id','state_id','user_id','car_initial_state','car_initial_date','car_final_state','car_final_date','car_workorder_price','client_sign'];


    /* PREVISTA PARA HACER INVENTARIO
    public function lines()
    {
        return $this->hasMany(Piece::class);
    }
    */
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function workorderState()
    {
        return $this->belongsTo(WorkorderState::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
