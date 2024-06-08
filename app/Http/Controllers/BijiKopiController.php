<?php

namespace App\Http\Controllers;

use App\Models\BijiKopi;
use App\Models\Kriteria;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BijiKopiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $kriterias = Kriteria::get();
        $bijiKopis = BijiKopi::get();
        return view('bijikopi.index', [
            'bijikopis' => $bijiKopis,
            // 'kriterias' => $kriterias
        ]);
    }

    public function storeTambah(Request $request)
    {
        
        $this->validate($request, [
            'nama' => 'required|max:255',
            'harga' => 'required|max:255',
        ]);

        $bijikopi = BijiKopi::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        $kriterias = Kriteria::get();

        foreach($kriterias as $kriteria){
            if($request[$kriteria->id]){
                Nilai::create([
                    'biji_kopi_id' => $bijikopi->id,
                    'kriteria_id' => $kriteria->id,
                    'sub_kriteria_id' => $request[$kriteria->id]
                ]);
            }
        }


        return redirect()->route('biji-kopi');
    }

    public function destroy(BijiKopi $bijikopi, Request $request)
    {
        $bijikopi->delete();
        return back();
    }

    public function edit(BijiKopi $bijikopi, Request $request)
    {
        $kriterias = Kriteria::get();
        $nilai = $bijikopi->nilai()->get();

        return view('editbijikopi', [
            'bijikopi' => $bijikopi,
            'kriterias' => $kriterias,
            'nilai' => $nilai,
        ]);
    }
    public function storeEdit(BijiKopi $bijikopi, Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:255',
            'harga' => 'required|max:255',
        ]);
        $bijikopi->nama = $request->nama;
        $bijikopi->harga = $request->harga;
        $bijikopi->save();

        $bijikopi->nilai()->delete();

        $kriteria = Kriteria::get();
        $kriteriaCount = $kriteria->count();
        for($i = 0; $i < $kriteriaCount; $i++){
            if(!$request[$kriteria[$i]->id]){
                continue;
            }
            $bijikopi->nilai()->create([
                'kriteria_id' => $kriteria[$i]->id,
                'sub_kriteria_id' => $request[$kriteria[$i]->id]
            ]);
        }

        return redirect()->route('biji-kopi');
    }
}
