@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <style>
        .action{
            width: 49.45px;
        }
    </style>
    @include('layouts.navbars.auth.topnav', ['title' => 'kriteria'])
    {{-- <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname ?? 'Firstname' }} {{ auth()->user()->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            Public Relations
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                    <i class="ni ni-app"></i>
                                    <span class="ms-2">App</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-email-83"></i>
                                    <span class="ms-2">Messages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span class="ms-2">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <div>
                            <h6>Kriteria Dan Bobot</h6>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah Kriteria dan Bobot</button>
                        </div>
                    </div>                    
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive p-0">
                   
                                    <table class="table align-items-center mb-0" id="kriteriaTable">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Kriteria</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Tipe</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Bobot</th>
                                                <th class="text-secondary action">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($kriterias as $kriteria)
        
                                            <tr>
                                                <td>
                                                    {{-- {{ $loop->index + 1 }} --}}
                                                    <div class="d-flex px-2 py-1">
                                                        {{-- <div>
                                                            <img src="/img/team-4.jpg" class="avatar avatar-sm me-3"
                                                                alt="user6">
                                                        </div> --}}
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $loop->index + 1 }}</h6>
                                                            {{-- <p class="text-xs text-secondary mb-0">miriam@creative-tim.com</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $kriteria->kriteria }}
                                                    {{-- <p class="text-xs font-weight-bold mb-0"> {{ $kriteria->kriteria }}</p>
                                                    <p class="text-xs text-secondary mb-0">Developer</p> --}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm bg-gradient-secondary">{{ $kriteria->tipe }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">  {{ $kriteria->bobot }}</span>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{ route('kriteria.delete', $kriteria->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="btn btn-sm btn-warning btn-sm m-0">edit</a>
                                                        <button class="btn btn-sm btn-danger btn-sm m-0" type="submit">
                                                            delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                        
                </div>
            </div>
        </div>
    </div>
    <!-- Tambah Data Modal -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Kriteria dan Bobot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <!-- Isi Form Tambah Data -->
                    <form class="modal-body mx-3" method="POST" action="{{ route('store-kriteria') }}">
                        @csrf
                        <div class="md-form">
                            <label for="kriteria">Kriteria</label>
                            <input class="form-control" value="{{ old('kriteria') }}" type="text" name="kriteria" id="kriteria" required>
                            @error('kriteria')
                            <div>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form">
                                    <label for="kriteria">Tipe</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="cost" name="tipe" value="cost" checked>
                                        <label class="custom-control-label" for="cost">Cost</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form">
                                    <label for="kriteria" class="invisible">Tipe</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="benefit" name="tipe" value="benefit">
                                        <label class="custom-control-label" for="benefit">Benefit</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md-form">
                            <label for="bobot">Bobot</label>
                            <input class="form-control" value="{{ old('bobot') }}" type="number" name="bobot" id="bobot" required>
                            @error('bobot')
                            <div>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div id="dynamic-form">
                            <label for="">Sub Kriteria</label>
                        </div>
                        <button class="btn btn-sm btn-success" type="button" id="add-kriteria">
                            Tambah Kriteria
                        </button>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="btn btn-secondary" type="submit">Tambah Data Kriteria</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kriteriaTable').DataTable();
        });

    </script>
    <script type="text/javascript">
        var counter = 0;
            $("#add-kriteria").click(function () {
                console.log("tst")
                ++counter;
                $("#dynamic-form").append(`<div class="form-row mb-1 md-form">
                                                <div class="col" >
                                                    <label for="input-pilihan-${counter}">Item Sub Kriteria </label>
                                                    <input class="form-control" type="text" name="pilihan[${counter}]" id="input-pilihan-${counter}" value="" required >
                                                </div> 
                                                <button class="btn btn-sm btn-danger remove-input-field">Remove</button> 
                                            </div>`
                    );
            });
            $(document).on('click', '.remove-input-field', function () {
                $(this).parent('div').remove();
            });
        </script>
@endsection
