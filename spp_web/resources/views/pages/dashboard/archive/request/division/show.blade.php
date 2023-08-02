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
                    <legend>Detail</legend>
                    <x-form.input.text name="farmer_id" title="Kelompok Tani" :value="$datas['request']->farmer->name" :in-line="true" />
                    <x-form.input.text name="program_id" title="Kamus Usulan" :value="$datas['request']->program->name" :in-line="true" />
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
                                <a href="{{ $attachment->url }}" class="mr-1 btn btn-primary col-1" target="_blank">View</a>
                            </div>
                        @endforeach
                    </div>
                </div>

                @isset($datas['request']->result)
                    <fieldset @if ($datas['request']->status == 'done') disabled @endif>
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
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Dokumentasi Realisasi</label>
                            <div class="col-sm-10">
                                @forelse ($datas['request']->result->attachments as $index => $attachment)
                                    <div class="mb-2 attachment-name-group d-flex align-items-center form-group row">
                                        <input type="text" name="attachments[{{ $index }}][name]"
                                            class="mr-2 form-control col" value="{{ $attachment->name }}" disabled readonly>
                                        <a href="{{ $attachment->url }}" class="mr-1 btn btn-primary col-1"
                                            target="_blank">View</a>
                                        <a href="{{ route('dashboard.request.attachment.destroy', [$datas['request']->result, $attachment]) }}"
                                            class="btn btn-danger col-1">Delete</a>
                                    </div>
                                @empty
                                    -
                                @endforelse
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tambah Dokumentasi Realisasi</label>
                            <div class="col-sm-10" id="attachment_names_container">
                                <div class="mb-2 attachment-name-group d-flex align-items-center row">
                                    <div class="col-5 form-group">
                                        <input type="text" name="attachments[][name]" class="form-control"
                                            placeholder="Attachment Name">
                                    </div>
                                    <div class="col-5 form-group">
                                        <div class="custom-file">
                                            <input type="file" name="attachments[][file]" class="custom-file-input">
                                            <label class="custom-file-label" for="attachment_files[]">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 offset-sm-2">
                                <button type="button" class="btn btn-secondary" id="add_attachment">Add Attachment</button>
                            </div>
                        </div>
                    </fieldset>
                @endisset
            </div>
            <div class="card-footer d-flex justify-content-end">
                @if ($datas['request']->status == 'requested')
                    <button type="submit" name="status" value="pending" class="btn btn-primary mr-2">Ajukan ke
                        Kadis</button>
                @endif
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
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
    @isset($datas['request']->result)
        <script>
            $(document).ready(function() {
                var attachmentIndex = {{ count($datas['request']->result->attachments) }};

                $('#add_attachment').on('click', function() {
                    var attachmentGroup = `
        <div class="mb-2 attachment-name-group d-flex align-items-center row">
            <div class="col-5 form-group">
                <input type="text" name="attachments[][name]" class="form-control" placeholder="Attachment Name">
            </div>
            <div class="col-5 form-group">
                <div class="custom-file">
                    <input type="file" name="attachments[][file]" class="custom-file-input">
                    <label class="custom-file-label" for="attachment_files[]">Choose file</label>
                </div>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-danger btn-remove-attachment">Remove</button>
            </div>
        </div>
        `;
                    $('#attachment_names_container').append(attachmentGroup);
                    attachmentIndex++;
                });

                $(document).on('change', '.custom-file-input', function() {
                    var fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').text(fileName);
                });

                $(document).on('click', '.btn-remove-attachment', function() {
                    $(this).closest('.attachment-name-group').remove();
                });
            });
        </script>
    @endisset
@endsection
