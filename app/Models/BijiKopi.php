<?php

namespace App\Models;

use App\Models\Kriteria;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BijiKopi extends Model
{
    use HasFactory;

    protected $table = 'biji_kopi';

    protected $fillable = [
        'nama',
        'harga'
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'biji_kopi_id');
    }
    public function nilaiKriteriaTabel1(Kriteria $kriteria)
    {
            $subKriteriaCount = SubKriteria::where('kriteria_id', $kriteria->id)->count();
            if(!$this->hasMany(Nilai::class, 'biji_kopi_id')->where('kriteria_id', $kriteria->id)->first()){
                return false;
            }
            $bijikopi = $this->hasMany(Nilai::class, 'biji_kopi_id')->where('kriteria_id', $kriteria->id)->first();
            $hasil = $bijikopi->subKriteria()->value;
            if(!$hasil){
                return false;
            }
            $hasil = (float)$hasil / $subKriteriaCount * 100;
            $hasil = number_format($hasil, 2, '.', ',');
            return $hasil;
    }

    public function dataKriteriaCostBenefit(Kriteria $kriteria)
    {
            if(!$this->hasMany(Nilai::class, 'biji_kopi_id')->where('kriteria_id', $kriteria->id)->first()){
                return false;
            }
            $bijikopi = $this->hasMany(Nilai::class, 'biji_kopi_id')->where('kriteria_id', $kriteria->id)->first();
            $hasil = $bijikopi->subKriteria()->value;
            $hasil = (float)$hasil;
            return $hasil;
    }

    public function nilaiKriteriaTabel2(Kriteria $kriteria)
    {
        $nilaiCollections = $kriteria->nilai()->get();
        foreach ($nilaiCollections as $nilaiCollection) {
            $value[] = $nilaiCollection->SubKriteria()->value;
        }
        if(!$this->dataKriteriaCostBenefit($kriteria)){
            return false;
        }
        if ($kriteria->tipe == 'cost') {
            $divider = min($value);
            return $divider / $this->dataKriteriaCostBenefit($kriteria);
        } else {
            $divider = max($value);
            return $this->dataKriteriaCostBenefit($kriteria) / $divider;
        }
    }

    public function nilaiKriteriaTabel3(Kriteria $kriteria)
    {
        if(!$this->nilaiKriteriaTabel2($kriteria)){
            return false;
        }
        return $this->nilaiKriteriaTabel2($kriteria) * $kriteria->bobot;
    }

    public function nilaiKriteriaTabel4()
    {
        
        $kriterias = Kriteria::get();
        $total = 0;
        foreach ($kriterias as $kriteria) {
            if(!$this->nilaiKriteriaTabel3($kriteria)){
                return false;
            }
            $total += $this->nilaiKriteriaTabel3($kriteria);
        }
        return $total;
    }

    public function ranking()
    {
        $bijikopis = BijiKopi::get();
        if(!$this->nilaiKriteriaTabel4()){
            return false;
        }
        $currentTotal = $this->nilaiKriteriaTabel4();
        foreach ($bijikopis as $bijikopi) {
            $total[] = $bijikopi->nilaiKriteriaTabel4();
        }
        rsort($total);
        for ($i = 0; $i <= count($total); $i++) {
            if ($total[$i] == $currentTotal) {
                return $i + 1;
            }
        }
    }



    public function isFilledKriteria(Kriteria $kriteria)
    {
        return $this->nilai->contains('kriteria_id', $kriteria->id);
    }

    public function findSubKriteriaId(Kriteria $kriteria)
    {
        return $this->nilai->where('kriteria_id', $kriteria->id)->first()->sub_kriteria_id;
    }
}
