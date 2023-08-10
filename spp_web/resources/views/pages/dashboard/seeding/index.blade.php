@extends('layouts.app')

@section('title', 'Upload Database')

@section('content')
    @if (Session::has('additionalMessage'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('additionalMessage') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mass Upload</h3>
        </div>
        <div class="card-body">
            @if ($tablesFilled)
                @role('kadis')
                    <fieldset>
                        <form action="{{ route('dashboard.setting.seeding.store.complete') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <legend>Upload Data Kecamatan, Desa, dan Kelompok Tani</legend>
                            <div class="form-group">
                                <label for="complete-file"></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="complete-file" name="file">
                                    <label class="custom-file-label" for="complete-file">Choose file</label>
                                </div>
                            </div>
                            @error('file')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="with_village_user"
                                        id="with_village_user" @checked(old('with_village_user')) value="true">
                                    <label class="custom-control-label" for="with_village_user">Buat akun Koor untuk setiap
                                        desa.</label>
                                </div>
                            </div>
                            @error('with_village_user')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="d-flex d-inline justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </fieldset>
                @endrole
            @else
                Data awal yang dibutuhkan (Kecamatan, Desa, dan Kelompok Tani) sudah terisi.
            @endif
        </div>
    </div>
@endsection
