<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coment extends Model
{
    use HasFactory;
    protected $table = "coment";
    protected $fillable = ['id','coment']; 
    public function todos(){
        return $this->belongsToMany(Todo::class);
    }
}
