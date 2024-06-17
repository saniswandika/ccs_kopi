@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container">
    <div class="row justify-content-center  mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white h5 bg-dark">
                    Edit Kriteria dan Bobot
                </div>
                <form method="POST" action="{{ route('kriteria.update', $kriteria->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kriteria" class="form-label">Kriteria</label>
                            <input type="text" class="form-control @error('kriteria') is-invalid @enderror" id="kriteria" name="kriteria" value="{{ old('kriteria', $kriteria->kriteria) }}" required>
                            @error('kriteria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tipe</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe" id="cost" value="cost" {{ $kriteria->tipe == 'cost' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cost">Cost</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label invisible">Tipe</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe" id="benefit" value="benefit" {{ $kriteria->tipe == 'benefit' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="benefit">Benefit</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bobot" class="form-label">Bobot</label>
                            <input type="number" class="form-control @error('bobot') is-invalid @enderror" id="bobot" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required>
                            @error('bobot')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div id="dynamic-form">
                            <label class="form-label">Sub Kriteria</label>
                            @foreach ($subKriterias as $subKriteria)
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="pilihan[]" value="{{ $subKriteria->nama }}" placeholder="Item Sub Kriteria" required>
                                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-sub-kriteria">Remove</button>
                                </div>
                            @endforeach
                        </div> --}}
                        <div id='dynamic-form' class="text-center">
                            <label for=""><b> Sub Kriteria </b></label>
                            @foreach ($sub_kriteria as $item)
                            <div class="md-form form-row">
                                <div class="col">
                                    <input class="form-control" type="text" name="pilihan[{{ $loop->index+1 }}]"
                                        id="input-pilihan-{{ $loop->index+1 }}" value="{{ $item->sub_kriteria }}"
                                        required>
                                </div>
                                <button class="btn btn-sm btn-danger remove-input-field mt-2">Remove</button>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-sm btn-success mt-3" id="add-kriteria">Tambah Kriteria</button>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <a href="{{ route('kriteria') }}" class="btn btn-secondary">Batal Perubahan</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        var counter = {{ $sub_kriteria->count() }}; // Mengambil jumlah sub kriteria yang sudah ada

        $("#add-kriteria").click(function() {
            counter++;
            $("#dynamic-form").append(`<div class="form-group mb-3">
                                            <input type="text" class="form-control" name="pilihan[]" placeholder="Item Sub Kriteria ${counter}" required>
                                            <button type="button" class="btn btn-sm btn-danger mt-2 remove-sub-kriteria">Remove</button>
                                        </div>`);
        });

        $(document).on('click', '.remove-sub-kriteria', function() {
            $(this).parent().remove();
        });
    });

</script>
@endsection
