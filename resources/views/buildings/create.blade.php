@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/multi-select/multi-select.css') }}">
@endsection

@section('content')
    <section class="container py-3">
        <h4 class="mb-3">Building Addresses</h4>

        @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <form action="{{ route('building.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-6">
                    <label for="building" class="form-label mt-2">Building Name</label>
                    <input type="text" id="building" class="form-control" placeholder="Building name" name="building" autocomplete="off" required="">
                </div>

                <div class="col-6">
                    <label for="district" class="form-label mt-2">District</label>
                    <select name="district" id="district" class="form-control" autocomplete="off">
                        <option selected disabled>District</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district }}">{{ $district }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="address" class="form-label mt-2">Address</label>
                    <input type="text" id="address" class="form-control" placeholder="Address" name="address">
                </div>

                <div class="col-6">
                    <label for="address_chinese" class="form-label mt-2">Address Chinese</label>
                    <input type="text" id="address_chinese" class="form-control" placeholder="Address Chinese" name="address_chinese">
                </div>

                <div class="col-6">
                    <label for="usageSelect" class="form-label mt-2">Usage</label>
                    <select id="usageSelect" name="usage[]" multiple="multiple">
                        @foreach ($usage as $use)
                            <option value="{{ $use }}">{{ $use }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="property_type" class="form-label mt-2">Property Type</label>
                    <input type="text" id="property_type" class="form-control" placeholder="種類 Property Type" name="property_type">
                </div>

                <div class="col-6">
                    <label for="year_of_completion" class="form-label mt-2">Year of Completion</label>
                    <input type="text" id="year_of_completion" class="form-control" placeholder="落成年份 Year of Completion" name="year_of_completion">
                </div>

                <div class="col-6">
                    <label for="title" class="form-label mt-2">Title</label>
                    <input type="text" id="title" class="form-control" placeholder="業權 Title" name="title">
                </div>

                <div class="col-6">
                    <label for="management_company" class="form-label mt-2">Management Company</label>
                    <input type="text" class="form-control" placeholder="管理公司 Management Company" name="management_company" id="management_company">
                </div>

                <div class="col-6">
                    <label for="transportation" class="form-label mt-2">Transportation</label>
                    <input type="text" class="form-control" placeholder="交通 Transportation" name="transportation" id="transportation">
                </div>

                <div class="col-6">
                    <label for="developers" class="form-label mt-2">Developers</label>
                    <input type="text" class="form-control" placeholder="發展商 Developers" name="developers" id="developers">
                </div>

                <div class="col-6">
                    <label for="floor" class="form-label mt-2">Floor</label>
                    <input type="text" class="form-control" placeholder="層數 Floor" name="floor" id="floor">
                </div>

                <div class="col-6">
                    <label for="floor_area" class="form-label mt-2">Floor Area</label>
                    <input type="text" class="form-control" placeholder="全層面積 Floor Area" name="floor_area" id="floor_area">
                </div>

                <div class="col-6">
                    <label for="height" class="form-label mt-2">Height</label>
                    <input type="text" class="form-control" placeholder="樓高 Height" name="height" id="height">
                </div>

                <div class="col-6">
                    <label for="air_con_system" class="form-label mt-2">A/C System</label>
                    <input type="text" class="form-control" placeholder="冷氣系統 A/C System" name="air_con_system" id="air_con_system">
                </div>

                <div class="col-6">
                    <label for="lifts" class="form-label mt-2">Lifts</label>
                    <input type="text" class="form-control" name="lifts" id="lifts">
                </div>

                <div class="col-6">
                    <label for="parking" class="form-label mt-2">Parking</label>
                    <input type="text" class="form-control" name="parking" id="parking">
                </div>

                <div class="col-6">
                    <label for="carpark" class="form-label mt-2">Car Park</label>
                    <input type="text" class="form-control" placeholder="停車場 Car Park" name="carpark" id="carpark">
                </div>

                <div class="col-md-12 d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
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
