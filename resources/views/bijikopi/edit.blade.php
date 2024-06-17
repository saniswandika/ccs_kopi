@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container animated fadeIn">
    <div class="row justify-content-center mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white h5 bg-dark">
                    Edit Biji Kopi
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('biji-kopi.edit.post', $bijikopi->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="md-form">
                            <label for="nama">Nama</label>
                            <input class="form-control" value="{{ $bijikopi->nama }}" type="text" name="nama" id="nama">
                            @error('nama')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="md-form">
                            <label for="harga">Harga</label>
                            <input class="form-control" value="{{ $bijikopi->harga }}" type="number" name="harga" id="harga">
                            @error('harga')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @foreach ($kriterias as $kriteria)
                            <h5>{{ $kriteria->kriteria }}</h5>
                            <div class="mb-3">
                                @foreach ($kriteria->subKriteria as $item)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="{{ $item->id }}" name="kriteria[{{ $kriteria->id }}]" value="{{ $item->id }}" {{ ($bijikopi->isFilledKriteria($kriteria) && $bijikopi->findSubKriteriaId($kriteria) == $item->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $item->id }}">{{ $item->sub_kriteria }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="modal-footer d-flex justify-content-center">
                            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                            <a href="{{ route('biji-kopi') }}" class="btn btn-secondary">Batal Perubahan</a>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var counter = {{ count($kriterias) }}; // Inisialisasi counter berdasarkan jumlah kriteria
            $("#add-kriteria").click(function () {
                ++counter;
                $("#dynamic-form").append(`
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="pilihan[]" id="input-pilihan-${counter}" value="" placeholder="Item Sub Kriteria" required>
                        <input type="number" class="form-control" name="nilai[]" id="input-nilai-${counter}" value="" placeholder="Nilai" required>
                        <button type="button" class="btn btn-sm btn-danger mt-2 remove-sub-kriteria">Remove</button>
                    </div>
                `);
            });

            $(document).on('click', '.remove-sub-kriteria', function () {
                $(this).parent('.form-group').remove();
            });
        });
    </script>
@endpush
