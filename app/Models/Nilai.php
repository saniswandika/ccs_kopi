<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'biji_kopi_id',
        'kriteria_id',
        'sub_kriteria_id',
    ];

    public function kriteria(){
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

    public function bijiKopi(){
        return $this->belongsTo(BijiKopi::class, 'biji_kopi_id');
    }
    
    public function subKriteria(){
        return $this->belongsTo(SubKriteria::class, 'sub_kriteria_id')->first();
    }
}
