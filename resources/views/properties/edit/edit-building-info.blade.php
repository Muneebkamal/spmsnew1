@extends('layouts.app')

@section('styles')
    {{-- <style>
    .log_btn {
        background-color: #05445E;
        transition: 0.7s;
        color: #fff;
    }
    .log_btn:hover {
        background-color: #189AB4;
        color: #fff;
    }
    .nav-link {
        display: block;
        padding: .5rem 1rem;
    }
    .list-group {
        height: 300px;
        background-color: skyblue;
        /* width: 200px; */
        overflow-y: scroll;
    }
</style> --}}
@endsection

@section('content')
    <form action="{{ route('update.buildinginfo', $property->code) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mt-2">
            <div class="container">
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1"
                    style="position: static; left: auto; display: block;">
                    <h3>Building Info</h3>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Code</label>
                            <input type="text" class="form-control mb-3" placeholder="Code" id="code" name="code"
                                required="" value="{{ $property->code }}" readonly>
                            <div id="outputC"></div>
                        </div>
                        <div class="col-6">
                            <label for="">District</label>
                            <select name="district" id="district" class="form-control mb-3" autocomplete="off">
                                <option selected disabled>District</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district }}"
                                        {{ $property->district == $district ? 'selected' : '' }}>
                                        {{ $district }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="">Building</label>
                            <input type="text" id="building" class="form-control mb-3" placeholder="Building name"
                                name="building" autocomplete="off" required="" value="{{ $property->building }}">
                            <div id="outputB" class=""></div>
                        </div>
                        <div class="col-6">
                            <label for="">Address</label>
                            <input type="text" id="address" class="form-control mb-3" placeholder="Address"
                                name="street" value="{{ $property->street }}">
                        </div>
                        <div class="col-6">
                            <label for="">Block</label>
                            <input type="text" class="form-control mb-3" placeholder="Block" name="block"
                                autocomplete="off" value="{{ $property->block }}">
                        </div>
                        <div class="col-6">
                            <label for="">Floor</label>
                            <input type="text" class="form-control mb-3" placeholder="Floor" name="floor"
                                autocomplete="off" value="{{ $property->floor }}">
                        </div>
                        <div class="col-6">
                            <label for="">Flat</label>
                            <input type="text" class="form-control mb-3" placeholder="Flat" name="flat"
                                autocomplete="off" value="{{ $property->flat }}">
                        </div>
                        <div class="col-6">
                            <label for="">Room Number</label>
                            <input type="number" class="form-control mb-3" placeholder="No of Rooms" name="no_rooms"
                                id="no_rooms" value="{{ $property->no_room }}">
                        </div>
                        <p class="mb-0">Room Display By</p>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline1" name="display" class="custom-control-input"
                                value="alp" data-parsley-multiple="display"
                                {{ $property->display_by == 'alp' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customRadioInline1">A,B,C,D...</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadioInline2" name="display" class="custom-control-input"
                                value="num" data-parsley-multiple="display"
                                {{ $property->display_by == 'num' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customRadioInline2">1,2,3,4...</label>
                        </div>
                        <div class="col-6">
                            <label for="" class="d-block">24 hour</label>
                            <select id="" name="tf_hr" class="form-control mb-4">
                                <option value="Yes" {{ $property->tf_hr == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $property->tf_hr == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="">Building Loading</label>
                            <input type="text" class="form-control mb-3" placeholder="Building Loading"
                                name="building_loading" id="building_loading" autocomplete="off"
                                value="{{ $property->building_loading }}">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control mt-3" placeholder="級別 Grade" name="grade"
                                id="grade">
                        </div>
                        <div class="col-12 mb-2">
                            <label for="">Enter Password</label>
                            <input type="text" class="form-control mb-2" placeholder="Entry Password"
                                name="entry_password" value="{{ $property->enter_password }}">
                        </div>
                        <div class="col-12 mb-2">
                            <textarea name="admin_comment" class="form-control" id="" cols="30" rows="3"
                                placeholder="Admin Comment"></textarea>
                        </div>
                        <div class="col-12">
                            <h3>Building Details</h3>
                        </div>
                        <input type="hidden" class="form-control mt-3" placeholder="bid" name="bid"
                            value="{{ $property->bid }}" id="bid">
                        <div class="col-12 pt-3">
                            <input type="text" readonly id="building_district" class="form-control"
                                placeholder="District" name="building_district"
                                value="{{ $property->property_building?->district }}">
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" readonly id="property_type" class="form-control"
                                value="{{ $property->property_building?->property_type }}" placeholder="種類 Property Type"
                                name="property_type">
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" readonly id="year" class="form-control"
                                value="{{ $property->property_building?->year_of_completion }}"
                                placeholder="落成年份 Year of Completion" name="year">
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" readonly id="title" class="form-control" placeholder="業權 Title"
                                value="{{ $property->property_building?->district }}" name="title">
                        </div>
                        <div class="col-12">
                            <input type="text" readonly class="form-control mt-3"
                                value="{{ $property->property_building?->management_company }}"
                                placeholder="管理公司 Management Company" name="management_company" id="management_company">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="發展商 Developers"
                                value="{{ $property->property_building?->developers }}" name="developers"
                                id="developers">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="交通 Transportation"
                                value="{{ $property->property_building?->transportation }}" name="transportation"
                                id="transportation">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="層數 Floor"
                                value="{{ $property->property_building?->floors }}" name="num_floors" id="num_floors">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="全層面積 Floor Area"
                                value="{{ $property->property_building?->floor_area }}" name="floor_area"
                                id="floor_area">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="樓高 Height"
                                value="{{ $property->property_building?->height }}" name="ceiling_height"
                                id="ceiling_height">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="冷氣系統 A/C System"
                                value="{{ $property->property_building?->air_con_system }}" name="air_con_system"
                                id="air_con_system">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="載貨電梯"
                                value="{{ $property->property_building?->lifts ? explode(',', $property->property_building?->lifts)[0] : '' }}"
                                name="cargo_lift" id="cargo_lift">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="停車場 Car Park"
                                value="{{ $property->property_building?->carpark }}" name="car_park" id="car_park">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="載客電梯"
                                value="{{ $property->property_building?->lifts ? explode(',', $property->property_building?->lifts)[1] : '' }}"
                                name="customer_lift" id="customer_lift">
                        </div>
                        <div class="col-6">
                            <input type="text" readonly class="form-control mt-3" placeholder="Usage" name="busage"
                                value="{{ $property->property_building?->usage }}" id="busage">
                        </div>
                    </div>
                    <button type="submit" name="submit"
                        class="btn btn-block font-weight-bold log_btn btn-lg mt-4">UPDATE</button>
                </div>
            </div>
        </div>
        <!-- </form> -->
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#code').keyup(function() {
                let code = $(this).val();
                if (code != '') {
                    $.ajax({
                        type: "POST",
                        url: "/check-code",
                        data: {
                            code: code,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: "html",
                        success: function(data) {
                            $('#outputC').fadeIn();
                            $('#outputC').html(data);
                        }
                    });
                } else {
                    $('#outputC').fadeOut();
                    $('#outputC').html("");
                }
            });

            $('#outputC').parent().on('click', 'li', function() {
                $('#code').val($(this).text());
                $('#outputC').fadeOut();
            });
        });

        $(document).ready(function() {
            $('#building').keyup(function() {
                let building = $(this).val();
                if (building !== '') {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('search.building') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            building: building
                        },
                        success: function(data) {
                            $('#outputB').fadeIn();
                            $('#outputB').html(data);
                        }
                    });
                } else {
                    $('#outputB').fadeOut();
                    $('#outputB').html("");
                }
            });

            $('#outputB').parent().on('click', 'li', function() {
                let text1 = $(this).text();
                $('#building').val(text1);
                $.ajax({
                    type: "POST",
                    url: "{{ route('get.building.info') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        text1: text1
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        if (data.address_chinese) {
                            $('#address').val(data.address_chinese);
                        }
                        if (data.bid) {
                            $('#bid').val(data.bid);
                        }
                        if (data.year) {
                            $('#year').val(data.year);
                        }
                        if (data.usage) {
                            $('#busage').val(data.usage);
                        }
                        if (data.district) {
                            $('#district').val(data.district);
                        }
                        if (data.height) {
                            $('#ceiling_height').val(data.height);
                        }
                        if (data.air_con_system) {
                            $('#air_con_system').val(data.air_con_system);
                        }
                        if (data.customer_lift) {
                            $('#customer_lift').val(data.customer_lift);
                        }
                        if (data.cargo_lift) {
                            $('#cargo_lift').val(data.cargo_lift);
                        }
                        if (data.carpark) {
                            $('#car_park').val(data.carpark);
                        }
                        if (data.floor_area) {
                            $('#floor_area').val(data.floor_area);
                        }
                        if (data.transportation) {
                            $('#transportation').val(data.transportation);
                        }
                        if (data.developers) {
                            $('#developers').val(data.developers);
                        }
                        if (data.district) {
                            $('#building_district').val(data.district);
                        }
                        if (data.property_type) {
                            $('#property_type').val(data.property_type);
                        }
                        if (data.building_district) {
                            $('#building_district').val(data.building_district);
                        }
                        if (data.management_company) {
                            $('#management_company').val(data.management_company);
                        }
                        if (data.title) {
                            $('#title').val(data.title);
                        }
                        if (data.floor) {
                            $('#num_floors').val(data.floor);
                        }
                        if (data.yt_link) {
                            $('#link').val(data.yt_link);
                        }
                    },
                    error: function() {
                        console.error('Building not found or error occurred');
                    }
                });

                // Hide the dropdown after selection
                $('#outputB').fadeOut();
            });
        });
    </script>
@endsection
