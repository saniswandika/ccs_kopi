<?php

namespace App\Http\Controllers;

use App\Models\BijiKopi;
use App\Models\Kriteria;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
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
            'kriterias' => $kriterias
        ]);
    }
    public function bijikopiDatatables(Request $request)
    {
        // Mengambil data dari request berupa tanggal
        $tanggal = $request->input('datepicker');
        // dd($tanggal);
        // Query untuk data Biji Kopi
        $bijiKopis = BijiKopi::select(['id', 'nama', 'harga', 'created_at']);
    
        // Jika ada tanggal yang dipilih, tambahkan kondisi where
        if (!empty($tanggal)) {
            $tanggal = Carbon::parse($tanggal)->toDateString(); // Mengubah format tanggal jika diperlukan
            $bijiKopis->whereDate('created_at', $tanggal);
        }
    
        // Menggunakan DataTables untuk memproses dan menghasilkan data
        return DataTables::of($bijiKopis)
            ->addColumn('action', function ($bijikopi) {
                return '<form method="POST" action="' . route('biji-kopi.delete', $bijikopi->id) . '">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<a href="' . route('biji-kopi.edit', $bijikopi->id) . '" class="btn btn-sm btn-warning">Edit</a>' .
                    '<button type="submit" class="btn btn-sm btn-danger ml-1">Delete</button>' .
                    '</form>';
            })
            ->addColumn('created_at_formatted', function ($bijikopi) {
                return optional($bijikopi->created_at)->format('Y-m-d H:i:s');
            })
            ->rawColumns(['action'])
            ->toJson();
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
        // dd($kriteria);

        $nilai = $bijikopi->nilai()->get();
        // dd($nilai);

        return view('bijikopi.edit', [
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
