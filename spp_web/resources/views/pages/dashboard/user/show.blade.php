@extends('layouts.app')

@section('title', 'Detail ' . $user->name)

@section('content')
    <form action="{{ route('dashboard.setting.user.update', $user) }}" method="POST" id="user-form">
        @csrf
        @method('PUT')
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Identitas</h3>
            </div>

            <div class="card-body">
                <x-form.input.text name="name" title="Name" :value="$user->name" :in-line="true" />
                <x-form.input.text name="email" title="Email" :value="$user->email" :in-line="true" />
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <strong>Role</strong>
                    </div>
                    <div class="col row">
                        @foreach ($roles as $role)
                            <div class="col">
                                <x-form.input.radio name="roles[]" :title="$role->name" :value="$role->id"
                                    id="{{ 'roles_' . $role->id }}" :checked="$user->roles->contains('id', $role->id)" />
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('roles')
                    <div class="mb-2 alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div id="divisions-form" style="display: none;">
                <hr>
                <div class="card-header">
                    <h3 class="card-title">Manajemen Bidang</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($divisions as $division)
                            <div class="col-md-3">
                                <x-form.input.checkbox name="divisions[]" :title="$division->name" :value="$division->id"
                                    id="{{ 'divisions_' . $division->id }}" :checked="$user->divisions->contains('id', $division->id)" />
                            </div>
                        @empty
                            <div class="col-md-3">
                                Belum ada data bidang tersimpan di database.
                                <a href="{{ route('dashboard.setting.division.create') }}">Klik di sini</a> untuk
                                menambahkan data Bidang
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div id="districts-form" style="display: none;">
                <hr>
                <div class="card-header">
                    <h3 class="card-title">Manajemen Desa</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="district-filter" class="col-sm-2 col-form-label">Filter districts</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="district-filter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="district-checkboxes">
                        @forelse ($districts as $district)
                            <div class="col-md-3">
                                <x-form.input.checkbox name="districts[]" :title="$district->name" :value="$district->id"
                                    id="{{ 'districts_' . $district->id }}" :checked="$user->districts->contains('id', $district->id)" />
                            </div>
                        @empty
                            <div class="col-md-3">
                                Belum ada data bidang tersimpan di database.
                                <a href="{{ route('dashboard.district.index') }}">Klik di sini</a> untuk
                                menambahkan data Desa
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @error('divisions')
                <div class="mb-2 alert alert-danger">{{ $message }}</div>
            @enderror
            @error('districts')
                <div class="mb-2 alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        // Get the checkboxes
        var rolesCheckboxes = document.querySelectorAll('[id^="roles_"]');
        var divisionsForm = document.getElementById('divisions-form');
        var districtsForm = document.getElementById('districts-form');
        var userForm = document.getElementById('user-form');
        var districtFilterInput = document.getElementById('district-filter');

        // Function to check if specific checkboxes are checked
        function areSpecificCheckboxesChecked(checkboxIds) {
            return checkboxIds.some(function(checkboxId) {
                var checkbox = document.getElementById(checkboxId);
                return checkbox && checkbox.checked;
            });
        }

        // Function to show or hide the forms based on checkbox state
        function toggleForms() {
            var divisionsFormVisible = areSpecificCheckboxesChecked(['roles_3']);
            var districtsFormVisible = areSpecificCheckboxesChecked(['roles_4']);
            divisionsForm.style.display = divisionsFormVisible ? 'block' : 'none';
            districtsForm.style.display = districtsFormVisible ? 'block' : 'none';

            // Disable or enable divisions checkboxes based on roles 1, 2, and 3
            var divisionsCheckboxes = divisionsForm.querySelectorAll('[id^="divisions_"]');
            divisionsCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = !divisionsFormVisible;
            });

            // Disable or enable districts checkboxes based on roles 1, 2, and 4
            var districtsCheckboxes = districtsForm.querySelectorAll('[id^="districts_"]');
            districtsCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = !districtsFormVisible;
            });
        }

        // Function to filter the districts based on the input value
        function filterdistricts() {
            var filter = districtFilterInput.value.toLowerCase();
            var checkboxes = districtsForm.querySelectorAll('[id^="districts_"]');

            checkboxes.forEach(function(checkbox) {
                var title = checkbox.nextElementSibling.innerText.toLowerCase();
                if (title.includes(filter)) {
                    checkbox.closest('.col-md-3').style.display = 'block';
                } else {
                    checkbox.closest('.col-md-3').style.display = 'none';
                }
            });
        }

        // Add event listeners to the checkboxes
        rolesCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', toggleForms);
        });

        // Add event listener to the district filter input
        districtFilterInput.addEventListener('input', filterdistricts);

        userForm.addEventListener('submit', function(event) {
            var divisionsCheckboxes = divisionsForm.querySelectorAll('[id^="divisions_"]:checked');
            var districtsCheckboxes = districtsForm.querySelectorAll('[id^="districts_"]:checked');

            // Remove unchecked divisions checkboxes from form data if roles 1, 2, and 3 are not checked
            if (!areSpecificCheckboxesChecked(['roles_3'])) {
                divisionsCheckboxes.forEach(function(checkbox) {
                    checkbox.disabled = true;
                    checkbox.removeAttribute('name');
                });
            }

            // Remove unchecked districts checkboxes from form data if roles 1, 2, and 4 are not checked
            if (!areSpecificCheckboxesChecked(['roles_4'])) {
                districtsCheckboxes.forEach(function(checkbox) {
                    checkbox.disabled = true;
                    checkbox.removeAttribute('name');
                });
            }
        });

        toggleForms();
    </script>
@endsection
