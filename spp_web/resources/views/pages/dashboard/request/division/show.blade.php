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
        <div class="card-body">
            <fieldset disabled="disabled" disabled="disabled">
                <legend>Detail Pengajuan <small>({{ __('status.' . $datas['request']->status) }})</small></legend>
                <x-form.input.text name="farmer_id" title="Kelompok Tani" :value="$datas['request']->farmer->name" :in-line="true" />
                <x-form.input.text name="proposal_dictionary_id" title="Kamus Usulan" :value="$datas['request']->program->name" :in-line="true" />
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
                                class="mr-1 btn btn-primary col-1" target="_blank">View</a>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($datas['request']->status == 'approved' || $datas['request']->status == 'done')
                <div class="card">
                    <div class="justify-center card-header">
                        <div class="card-title">
                            Hasil Pengaduan

                        </div>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#createResultModal">
                                Create New Request Result
                            </button>
                            <div class="modal fade" id="createResultModal" tabindex="-1" role="dialog"
                                aria-labelledby="createResultModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createResultModalLabel">Create New Request Result
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('dashboard.request.result.store', $datas['request']->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <x-form.input.hidden name="request_id" :value="$datas['request']->id" />
                                                <x-form.input.number name="volume" title="Volume" :value="old('volume')" />
                                                {{-- <div class="form-group">
                                                    <label for="attachments" class="col-form-label">Attachments</label>
                                                    <div id="attachments_container">
                                                        <div class="attachment-group row">
                                                            <div class="attachment-name col">
                                                                <input type="text" name="attachments[0][name]"
                                                                    class="form-control" placeholder="Attachment Name">
                                                            </div>
                                                            <div class="attachment-file col">
                                                                <div class="custom-file">
                                                                    <input type="file" name="attachments[0][file]"
                                                                        class="custom-file-input"
                                                                        accept=".png, .jpg, .jpeg, .pdf">
                                                                    <label class="custom-file-label"
                                                                        for="attachments[0][file]">Choose
                                                                        file</label>
                                                                </div>
                                                            </div>
                                                            <div class="attachment-remove">
                                                                <button type="button"
                                                                    class="btn btn-danger remove-attachment">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="mt-2 btn btn-secondary"
                                                        id="add_attachment">Add
                                                        Attachment</button>
                                                </div> --}}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover dataTable dtr-inline collapsed"
                            id="datatable-request-result">
                            <thead>
                                <tr>
                                    <th>Volume</th>
                                    <th>Satuan</th>
                                    <th>Dokumentasi Realisasi</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas['request']->results as $result)
                                    <tr>
                                        <td>{{ $result->volume }}</td>
                                        <td>
                                            {{ $result->unit->name }}
                                        </td>
                                        <td>
                                            <ul>
                                                @forelse ($result->attachments as $index => $attachment)
                                                    <li>
                                                        <a href="{{ route('storage.request-result-attachment', ['requestResultAttachment' => $attachment]) }}"
                                                            class="mr-1 btn btn-primary col-1"
                                                            target="_blank">{{ $attachment->name }}</a>
                                                    </li>
                                                @empty
                                                    -
                                                @endforelse
                                            </ul>
                                        </td>
                                        {{-- <td>
                                            <x-button text="Lihat" type="redirect" :route="route('dashboard.request.show', $result)" color="primary" />
                                            <x-button text="Hapus" type="delete" :route="route('dashboard.request.destroy', $result)" color="danger" />
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        @if ($datas['request']->status == 'pending' || $datas['request']->status == 'approved')
            <div class="card-footer d-flex justify-content-end">
                <form action="{{ route('dashboard.request.update', $datas['request']->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($datas['request']->status == 'pending')
                        <button type="submit" name="status" value="requested" class="mr-2 btn btn-primary">Ajukan ke
                            Kadis</button>
                    @endif
                </form>
                @if ($datas['request']->status == 'approved')
                    <button type="submit" class="btn btn-primary">Save</button>
                @endif
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#select2').select2({
                theme: 'bootstrap4',
                width: 'resolve'
            });

            var attachmentIndex = 0;

            $('#add_attachment').on('click', function() {
                var attachmentGroup = `
                    <div class="attachment-group row">
                        <div class="attachment-name col">
                            <input type="text" name="attachments[${attachmentIndex}][name]" class="form-control" placeholder="Attachment Name">
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
                attachmentIndex++;
            });
            $('#datatable-request-result').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
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
