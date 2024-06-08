<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {

        $kriterias = Kriteria::get();

        // dd($kriterias);
        return view('kriteria.index', [
            'kriterias' => $kriterias
        ]);
    }

    public function storeTambah(Request $request)
    {
        $this->validate($request, [
            'kriteria' => 'required|max:255',
            'tipe' => 'required|in:cost,benefit',
            'bobot' => 'required|integer',
            'pilihan' => 'required|array'
        ]);

        $kriteria = Kriteria::create([
            'kriteria' => $request->kriteria,
            'tipe' => $request->tipe,
            'bobot' => $request->bobot
        ]);

        $counter = 1;
        foreach ($request->pilihan as $pilihan) {
            SubKriteria::create([
                'sub_kriteria' => $pilihan,
                'value' => $counter,
                'kriteria_id' => $kriteria->id,
            ]);
            $counter++;
        }

        return redirect()->route('kriteria');
    }

    public function destroy(Kriteria $kriteria, Request $request)
    {
        $kriteria->delete();
        return back();
    }

    public function edit(Kriteria $kriteria, Request $request)
    {
        $subKriteria = $kriteria->subKriteria()->get();
        return view('editkriteria', [
            'kriteria' => $kriteria,
            'sub_kriteria' => $subKriteria
        ]);
    }
    public function storeEdit(Kriteria $kriteria, Request $request)
    {
        $this->validate($request, [
            'kriteria' => 'required|max:255',
            'tipe' => 'required|in:cost,benefit',
            'bobot' => 'required|integer',
            'pilihan' => 'required|array'
        ]);
        $kriteria->kriteria = $request->kriteria;
        $kriteria->tipe = $request->tipe;
        $kriteria->bobot = $request->bobot;
        $kriteria->save();

        $kriteria->subKriteria()->delete();


        $counter = 1;
        foreach ($request->pilihan as $pilihan) {
            SubKriteria::create([
                'sub_kriteria' => $pilihan,
                'value' => $counter,
                'kriteria_id' => $kriteria->id,
            ]);
            $counter++;
        }

        return redirect()->route('kriteria');
    }
}
