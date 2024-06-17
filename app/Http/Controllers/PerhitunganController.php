<?php

namespace App\Http\Controllers;

use App\Models\BijiKopi;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $bijikopis = BijiKopi::all();
        $kriterias = Kriteria::all();
        $bijiKopiCollection = [];
        $hasil = false;
    
        // Step 1: Normalisasi Matriks Keputusan
        $normalizedMatrix = [];
        foreach ($kriterias as $kriteria) {
            $sum = 0;
            foreach ($bijikopis as $bijikopi) {
                $sum += pow($bijikopi[$kriteria->kriteria], 2);
            }
            $sum = sqrt($sum);
    
            foreach ($bijikopis as $bijikopi) {
                $normalizedMatrix[$bijikopi->id][$kriteria->kriteria] = $sum != 0 ? $bijikopi[$kriteria->kriteria] / $sum : 0;
            }
        }
    
        // Step 2: Penghitungan Nilai Dominasi
        $dominanceScores = [];
        foreach ($bijikopis as $bijikopi) {
            $sumProduct = 0;
            $sumRatio = 0;
            foreach ($kriterias as $kriteria) {
                $weight = $kriteria->bobot;
                $normalizedValue = $normalizedMatrix[$bijikopi->id][$kriteria->kriteria];
                $sumProduct += $normalizedValue * $weight;
                $sumRatio += $normalizedValue != 0 ? $weight / $normalizedValue : 0;
            }
            $dominanceScores[$bijikopi->id] = [
                'sumProduct' => $sumProduct,
                'sumRatio' => $sumRatio
            ];
        }
    
        // Step 3: Menggabungkan Model untuk Mendapatkan Skor Akhir
        foreach ($bijikopis as $bijikopi) {
            $score = 0.5 * ($dominanceScores[$bijikopi->id]['sumProduct'] + $dominanceScores[$bijikopi->id]['sumRatio']);
            $bijiKopiCollection[] = [
                'bijikopi' => $bijikopi,
                'score' => $score
            ];
        }
    
        // Step 4: Mengurutkan Alternatif Berdasarkan Skor Akhir
        usort($bijiKopiCollection, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        // dd($bijikopi);
        // Alternatif dengan skor tertinggi
        $hasil = $bijiKopiCollection[0]['bijikopi'];
    
        // Ideal adalah alternatif dengan skor maksimal
        $ideal = $bijiKopiCollection[0]['bijikopi'];
    
        // Inti-ideal adalah alternatif dengan skor minimal
        $intiIdeal = $bijiKopiCollection[count($bijiKopiCollection) - 1]['bijikopi'];
    
        return view('Perhitungan.index', [
            'bijikopis' => $bijikopis,
            'kriterias' => $kriterias,
            'numberOne' => $hasil,
            'bijiKopiCollection' => $bijiKopiCollection,
            'ideal' => $ideal,
            'intiIdeal' => $intiIdeal
        ]);
    }
}
