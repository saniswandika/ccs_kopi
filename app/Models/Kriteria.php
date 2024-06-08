<?php

namespace App\Models;

use App\Models\SubKriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'kriteria',
        'tipe',
        'bobot'
    ];

    public function subKriteria(){
        return $this->hasMany(SubKriteria::class, 'kriteria_id');
    }
    
    public function nilai(){
        return $this->hasMany(Nilai::class, 'kriteria_id');
    }
}
