@extends('layouts.app')

@section('title', 'Create Request')

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
        <form action="{{ route('dashboard.request.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <x-form.input.option name="farmer_id" title="Kelompok Tani" :options="$datas['farmers']" :in-line="true"
                    id="farmer_id_option" :selected="old('farmer_id') ? old('farmer') : request()->query('farmer')" />
                <div class="form-group row">
                    <label for="proposal_dictionary_id" class="col-sm-2 col-form-label">Kamus Usulan</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" id="dictionary" name="proposal_dictionary_id"
                            style="width: 100%;">
                            <option @selected(old('proposal_dictionary_id') == '') value="" disabled>Pilih Kamus Usulan</option>
                            @foreach ($datas['divisionProposalDictionaries'] as $key => $proposalDictionaries)
                                <optgroup label="{{ $key }}">
                                    @foreach ($proposalDictionaries as $proposalDictionary)
                                        <option value="{{ $proposalDictionary->id }}" @selected(old('proposal_dictionary_id') == $proposalDictionary->id)>
                                            {{ $proposalDictionary->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                <x-form.input.number name="volume" title="Volume" :in-line="true" :value="old('volume')" />
                <x-form.input.option name="unit_id" title="Satuan" :options="$datas['units']" :in-line="true" :selected="old('unit_id')" />

                <div class="form-group">
                    <label for="attachments" class="col-form-label">Attachments</label>
                    <div id="attachments_container">
                        <div class="attachment-group row">
                            <div class="attachment-name col">
                                <input type="text" name="attachments[0][name]" class="form-control"
                                    placeholder="Attachment Name">
                            </div>
                            <div class="attachment-file col">
                                <div class="custom-file">
                                    <input type="file" name="attachments[0][file]" class="custom-file-input"
                                        accept=".png, .jpg, .jpeg, .pdf">
                                    <label class="custom-file-label" for="attachments[0][file]">Choose file</label>
                                </div>
                            </div>
                            <div class="attachment-remove">
                                <button type="button" class="btn btn-danger remove-attachment">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="mt-2 btn btn-secondary" id="add_attachment">Add Attachment</button>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#dictionary').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
            $('#select2').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
            $('#farmer_id_option').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });
            $('#add_attachment').on('click', function() {
                var attachmentIndex = $('.attachment-group').length;
                var attachmentGroup = `
                    <div class="attachment-group row">
                        <div class="attachment-name col">
                            <input type="text" name="attachments[${attachmentIndex}][name]" class="form-control"
                                placeholder="Attachment Name">
                        </div>
                        <div class="attachment-file col">
                            <div class="custom-file">
                                <input type="file" name="attachments[${attachmentIndex}][file]" class="custom-file-input" accept=".png, .jpg, .jpeg, .pdf">
                                <label class="custom-file-label" for="attachments[${attachmentIndex}][file]">Choose file</label>
                            </div>
                        </div>
                        <div class="attachment-remove">
                            <button type="button" class="btn btn-danger remove-attachment">Remove</button>
                        </div>
                    </div>
                `;
                $('#attachments_container').append(attachmentGroup);
            });

            $(document).on('change', '.custom-file-input', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').text(fileName);
            });

            $(document).on('click', '.remove-attachment', function() {
                $(this).closest('.attachment-group').remove();
            });
        });
    </script>
@endsection
