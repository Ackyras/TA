@extends('layouts.app')

@section('title', 'Upload Database')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mass Upload</h3>
        </div>
        <div class="card-body">
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
                        <div class="d-flex d-inline justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </fieldset>
            @endrole
        </div>
    </div>
@endsection
