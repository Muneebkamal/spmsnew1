@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/multi-select/multi-select.css') }}">
@endsection

@section('content')
    <section class="container py-3">
        <h4 class="mb-3">Edit Building Addresses</h4>

        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <form action="{{ route('building.update', $building->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-6">
                    <label for="building" class="form-label mt-2">Building Name</label>
                    <input type="text" id="building" class="form-control" name="building" value="{{ old('building', $building->building) }}" required>
                </div>

                <div class="col-6">
                    <label for="district" class="form-label mt-2">District</label>
                    <select name="district" id="district" class="form-control">
                        <option disabled>Select District</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district }}" {{ $building->district == $district ? 'selected' : '' }}>{{ $district }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="address" class="form-label mt-2">Address</label>
                    <input type="text" id="address" class="form-control" name="address" value="{{ old('address', $building->address) }}">
                </div>

                <div class="col-6">
                    <label for="address_chinese" class="form-label mt-2">Address Chinese</label>
                    <input type="text" id="address_chinese" class="form-control" name="address_chinese" value="{{ old('address_chinese', $building->address_chinese) }}">
                </div>

                <div class="col-6">
                    <label for="usageSelect" class="form-label mt-2">Usage</label>
                    <select id="usageSelect" name="usage[]" multiple="multiple">
                        @foreach ($usage as $use)
                            <option value="{{ $use }}" 
                                {{ in_array($use, explode(',', $building->usage ?? '')) ? 'selected' : '' }}>
                                {{ $use }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="property_type" class="form-label mt-2">Property Type</label>
                    <input type="text" id="property_type" class="form-control" name="property_type" value="{{ old('property_type', $building->property_type) }}">
                </div>

                <div class="col-6">
                    <label for="year_of_completion" class="form-label mt-2">Year of Completion</label>
                    <input type="text" id="year_of_completion" class="form-control" name="year_of_completion" value="{{ old('year_of_completion', $building->year_of_completion) }}">
                </div>

                <div class="col-6">
                    <label for="title" class="form-label mt-2">Title</label>
                    <input type="text" id="title" class="form-control" name="title" value="{{ old('title', $building->title) }}">
                </div>

                <div class="col-6">
                    <label for="management_company" class="form-label mt-2">Management Company</label>
                    <input type="text" id="management_company" class="form-control" name="management_company" value="{{ old('management_company', $building->management_company) }}">
                </div>

                <div class="col-6">
                    <label for="transportation" class="form-label mt-2">Transportation</label>
                    <input type="text" id="transportation" class="form-control" name="transportation" value="{{ old('transportation', $building->transportation) }}">
                </div>

                <div class="col-6">
                    <label for="developers" class="form-label mt-2">Developers</label>
                    <input type="text" id="developers" class="form-control" name="developers" value="{{ old('developers', $building->developers) }}">
                </div>

                <div class="col-6">
                    <label for="floor" class="form-label mt-2">Floor</label>
                    <input type="text" id="floor" class="form-control" name="floor" value="{{ old('floor', $building->floor) }}">
                </div>

                <div class="col-6">
                    <label for="floor_area" class="form-label mt-2">Floor Area</label>
                    <input type="text" id="floor_area" class="form-control" name="floor_area" value="{{ old('floor_area', $building->floor_area) }}">
                </div>

                <div class="col-6">
                    <label for="height" class="form-label mt-2">Height</label>
                    <input type="text" id="height" class="form-control" name="height" value="{{ old('height', $building->height) }}">
                </div>

                <div class="col-6">
                    <label for="air_con_system" class="form-label mt-2">A/C System</label>
                    <input type="text" id="air_con_system" class="form-control" name="air_con_system" value="{{ old('air_con_system', $building->air_con_system) }}">
                </div>

                <div class="col-6">
                    <label for="lifts" class="form-label mt-2">Lifts</label>
                    <input type="text" id="lifts" class="form-control" name="lifts" value="{{ old('lifts', $building->lifts) }}">
                </div>

                <div class="col-6">
                    <label for="parking" class="form-label mt-2">Parking</label>
                    <input type="text" id="parking" class="form-control" name="parking" value="{{ old('parking', $building->parking) }}">
                </div>

                <div class="col-6">
                    <label for="carpark" class="form-label mt-2">Car Park</label>
                    <input type="text" id="carpark" class="form-control" name="carpark" value="{{ old('carpark', $building->carpark) }}">
                </div>

                <div class="col-md-12 d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </section>

    <section class="" style="background-color: #fff;">
        <footer>
            <div class="container social_icon text-center">
                <hr class="font-weight-bold">
                <small class="text-center text-muted">Copyright 2024</small>
            </div>
        </footer>
    </section>
@endsection

@section('scripts')
<script src="{{ asset('assets/multi-select/multiselect.js') }}"></script>
<script>
    $('select[multiple]').multiselect({
        columns: 1,
        placeholder: 'Select',
        search: true,
        searchOptions: {
            'default': 'Search'
        },
        selectAll: true
    });
</script>
@endsection
