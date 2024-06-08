<?php

namespace App\Models;

use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubKriteria extends Model
{
    use HasFactory;

    protected $table = 'sub_kriteria';

    protected $fillable = [
        'sub_kriteria',
        'value',
        'kriteria_id'
    ];

    public function kriteria(){
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }

}
