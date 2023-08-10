@extends('layouts.app')

@section('title', 'Request')

@section('css')
    <style>
        .subprograms-container {
            display: none;
        }
    </style>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <form action="{{ route('dashboard.request.update', $datas['request']->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <fieldset disabled="disabled">
                    <legend>Detail Pengajuan <small>({{ __('status.' . $datas['request']->status) }})</small></legend>
                    <x-form.input.text name="farmer_id" title="Kelompok Tani" :value="$datas['request']->farmer->name" :in-line="true" />
                    <x-form.input.text name="program_id" title="Kamus Usulan" :value="$datas['request']->program->name" :in-line="true" />
                    {{-- <x-form.input.text name="status" title="Status" :value="__('status.' . $datas['request']->status)" :in-line="true" /> --}}
                    <x-form.input.number name="volume" title="volume" :value="$datas['request']->volume" :in-line="true" />
                    <x-form.input.option name="unit_id" title="Satuan" :options="$datas['units']" :disabled="true" :in-line="true"
                        :selected="$datas['request']->unit_id" />
                </fieldset>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Bukti Pendukung</label>
                    <div class="col-sm-10">
                        @foreach ($datas['request']->attachments as $index => $attachment)
                            <div class="mb-2 attachment-name-group d-flex align-items-center form-group row">
                                <input type="text" name="attachments[{{ $index }}][name]"
                                    class="mr-2 form-control col" value="{{ $attachment->name }}" disabled readonly>
                                <a href="{{ route('storage.request-attachment', ['requestAttachment' => $attachment]) }}"
                                    target="_blank" rel="noopener noreferrer" class="mr-1 btn btn-primary col-1">View</a>
                            </div>
                        @endforeach
                    </div>
                </div>

                @isset($datas['request']->result)
                    <fieldset disabled>
                        <legend>Hasil</legend>
                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control select2bs4" id="select2" name="status">
                                    <option @selected($datas['request']->status == 'requested') value="Requested">Requested</option>
                                    <option @selected($datas['request']->status == 'pending') value="Pending">Pending</option>
                                    <option @selected($datas['request']->status == 'on progress') value="On Progress">On Progress</option>
                                    <option @selected($datas['request']->status == 'declined') value="Declined">Declined</option>
                                    <option @selected($datas['request']->status == 'Done') value="Done">Done</option>
                                </select>
                            </div>
                        </div>
                        <x-form.input.number name="volume" title="volume" :value="$datas['request']->result->volume" :in-line="true" />
                        <x-form.input.option name="unit_id" title="Satuan" :options="$datas['units']" :in-line="true"
                            :selected="$datas['request']->result->unit_id" />
                    </fieldset>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Dokumentasi Realisasi</label>
                        <div class="col-sm-10">
                            @forelse ($datas['request']->result->attachments as $index => $attachment)
                                <div class="mb-2 attachment-name-group d-flex align-items-center form-group row">
                                    <input type="text" name="attachments[{{ $index }}][name]"
                                        class="mr-2 form-control col" value="{{ $attachment->name }}" disabled readonly>
                                    <a href="{{ route('storage.request-result-attachment', ['requestResultAttachment' => $attachment]) }}"
                                        target="_blank" rel="noopener noreferrer" class="mr-1 btn btn-primary col-1">View</a>
                                </div>
                            @empty
                                -
                            @endforelse
                        </div>
                    </div>
                @endisset
            </div>
            @if ($datas['request']->status == 'requested')
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" name="status" value="approved" class="btn btn-primary mr-2">Tandai
                        Setujui</button>
                    <button type="submit" name="status" value="declined" class="btn btn-warning mr-2">Tandai
                        Ditolak</button>
                </div>
            @endif
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#select2').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
        });
    </script>
@endsection
