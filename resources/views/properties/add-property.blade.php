@extends('layouts.app')

@section('styles')
    <!-- SmartWizard CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" /> --}}

    <!-- Include FilePond Core CSS -->
    <link rel="stylesheet" href="https://unpkg.com/filepond@4.32.1/dist/filepond.min.css" />

    <!-- Include FilePond Plugin CSS for Image Preview -->
    <link rel="stylesheet"
        href="https://unpkg.com/filepond-plugin-image-preview@4.6.11/dist/filepond-plugin-image-preview.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/multi-select/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/parsley-plugin/style.css') }}">

    {{-- <style>
    body {
        font-size: 12px !important;
    }
    .log_btn {
        background-color: #05445E;
        transition: 0.7s;
        color: #fff;
    }
    .log_btn:hover {
        background-color: #189AB4;
        color: #fff;
    }
    .sw-theme-arrows>.nav .nav-link.active {
        --sw-anchor-active-primary-color: #5bc0de;
    }
    .sw-theme-arrows > .nav .nav-link.default {
        cursor: pointer;
    }
    .sw>.nav .nav-link:active, .sw>.nav .nav-link:focus, .sw>.nav .nav-link:hover {
        text-decoration: none;
    }
    .sw-theme-arrows>.nav {
        overflow: hidden;
        border-bottom: 1px solid #eee;
    }
    .sw>.nav {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding-left: 0;
        margin-top: 0;
        margin-bottom: 0;
    }
    .sw.sw-justified>.nav>li {
        background-color: #F8F8F8;
    }
    .sw>.nav .nav-link {
        display: block;
        padding: .5rem 1rem;
        text-decoration: none;
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
    .filepond--root {
        max-width: 80%;
    }
</style> --}}
    <style>
        /* CSS */
        /* .log_btn {
                                                                                                                                                                                                  background-image: linear-gradient(144deg,#05445E, #009EF7 50%,#189AB4);
                                                                                                                                                                                                  box-shadow: 0 6px 15px rgba(0, 158, 247, 0.25);
                                                                                                                                                                                                  transition: all 0.3s ease;
                                                                                                                                                                                                  color: #fff;
                                                                                                                                                                                                  border: none;
                                                                                                                                                                                                }

                                                                                                                                                                                                .log_btn:hover {
                                                                                                                                                                                                  background-image: linear-gradient(144deg,#189AB4, #009EF7 50%, #05445E);
                                                                                                                                                                                                  box-shadow: 0 8px 18px rgba(24, 154, 180, 0.35);
                                                                                                                                                                                                }

                                                                                                                                                                                                .log_btn:active {
                                                                                                                                                                                                  transform: scale(0.95);
                                                                                                                                                                                                  background-image: linear-gradient(144deg,#05445E, #009EF7 50%,#189AB4);
                                                                                                                                                                                                  box-shadow: 0 4px 10px rgba(5, 68, 94, 0.35),
                                                                                                                                                                                                              0 2px 6px rgba(0, 158, 247, 0.25);
                                                                                                                                                                                                } */
        @media screen and (max-width: 640px) {
            .sw-theme-arrows>.nav .nav-link {

                text-align: center !important;
            }
        }

        .log_btn {
            background-image: linear-gradient(144deg, #0D47A1, #1976D2 50%, #42A5F5);
            box-shadow: 0 6px 15px rgba(25, 118, 210, 0.25);
            transition: all 0.3s ease;
            color: #fff;
            border: none;
            border-radius: 50px;
        }

        .log_btn:hover {
            background-image: linear-gradient(144deg, #42A5F5, #1976D2 50%, #0D47A1);
            box-shadow: 0 8px 18px rgba(25, 118, 210, 0.35);
        }

        .log_btn:active {
            transform: scale(0.95);
            background-image: linear-gradient(144deg, #0D47A1, #1976D2 50%, #42A5F5);
            box-shadow: 0 4px 10px rgba(13, 71, 161, 0.35),
                0 2px 6px rgba(25, 118, 210, 0.25);
        }

        .form-control {
            border-radius: 1rem;
        }

        .ms-options-wrap>button {
            border-radius: 1rem;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('add.property.save') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
        @csrf
        <!-- <form action="" method="post"> -->
        <div class="mt-5">
            <div class="container">
                <div class="d-flex justify-content-end mb-3">
                    <a class="mt-2 ml-2 btn btn-sm log_btn px-3" href="{{ route('properties.import') }}">Bulk Property
                        Import</a>
                </div>

                @if ($errors->has('code'))
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>{{ $errors->first('code') }}</strong>
                    </div>
                @endif

                <div id="smartwizard" class="bg-white main2 sw sw-theme-arrows sw-justified" style="height: auto;">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="#step-1">
                                <strong>Building Info</strong>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-4">
                                <strong>Landlord Details</strong>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-5">
                                <strong>FTOD</strong>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-6">
                                <strong>Size/Price</strong>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" style="height: auto;">
                        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1"
                            style="position: static; left: auto; display: block;">
                            <h3>Building Info</h3>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Code" id="code"
                                        name="code" required="">
                                    <div id="outputC"></div>
                                </div>
                                <div class="col-6">
                                    <select name="district" id="district" class="form-control mt-3" autocomplete="off">
                                        <option selected disabled>District</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district }}">
                                                {{ $district }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="building" class="form-control mt-3"
                                        placeholder="Building name" name="building" autocomplete="off" required="">
                                    <div id="outputB" class=""></div>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="address" class="form-control mt-3" placeholder="Address"
                                        name="street">
                                </div>

                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Block" name="block"
                                        autocomplete="off">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Floor" name="floor"
                                        id="floor" autocomplete="off">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Flat" name="flat"
                                        autocomplete="off">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control mt-3" placeholder="No of Rooms"
                                        name="no_rooms" id="no_rooms">
                                </div>
                                <div class="col-12 mt-2">
                                    <input type="text" class="form-control mt-3" placeholder="Entry Password"
                                        name="entry_password">
                                </div>
                                <div class="col-12 mt-2">
                                    <textarea name="admin_comment" class="form-control" id="admin_comment" cols="30" rows="3"
                                        placeholder="Admin Comment"></textarea>
                                </div>
                                <div class="col-12">
                                    <h3>Building Details</h3>
                                </div>
                                <input type="hidden" class="form-control mt-3" placeholder="bid" name="bid"
                                    id="bid">
                                <div class="col-12 pt-3">
                                    <input type="text" readonly id="building_district" class="form-control"
                                        placeholder="District" name="building_district">
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" readonly id="property_type" class="form-control"
                                        placeholder="種類 Property Type" name="property_type">
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" readonly id="year" class="form-control"
                                        placeholder="落成年份 Year of Completion" name="year">
                                </div>
                                <div class="col-12 pt-3">
                                    <input type="text" readonly id="title" class="form-control"
                                        placeholder="業權 Title" name="title">
                                </div>
                                <div class="col-12">
                                    <input type="text" readonly class="form-control mt-3"
                                        placeholder="管理公司 Management Company" name="management_company"
                                        id="management_company">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3" placeholder="發展商 Developers"
                                        name="developers" id="developers">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3"
                                        placeholder="交通 Transportation" name="transportation" id="transportation">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3" placeholder="層數 Floor"
                                        name="num_floors" id="num_floors">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3"
                                        placeholder="全層面積 Floor Area" name="floor_area" id="floor_area">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3" placeholder="樓高 Height"
                                        name="ceiling_height" id="ceiling_height">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3"
                                        placeholder="冷氣系統 A/C System" name="air_con_system" id="air_con_system">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3" placeholder="載貨電梯"
                                        name="cargo_lift" id="cargo_lift">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3" placeholder="停車場 Car Park"
                                        name="car_park" id="car_park">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3" placeholder="載客電梯"
                                        name="customer_lift" id="customer_lift">
                                </div>
                                <div class="col-6">
                                    <input type="text" readonly class="form-control mt-3" placeholder="Usage"
                                        name="busage" id="busage">
                                </div>

                                <div class="col-12">
                                    <label for="" class="mt-3 d-block">24 hour</label>
                                    <select id="tf_hr" name="tf_hr" class="form-control">
                                        <option value="Yes" selected="">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="級別 Grade"
                                        name="grade" id="grade">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="樓面承重"
                                        name="building_loading" id="building_loading">
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="submit"
                                        class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                                </div>
                                <div class="col-12 mt-4">
                                    <input id="tempId" name="tempId" type="hidden" value="{{ $tempId }}">
                                    <input type="file" class="filepond" name="filepond" multiple />
                                </div>
                            </div>
                            <button type="submit" name="submit"
                                class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                        </div>


                        <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4"
                            style="display: none;">
                            <h3>Landlord Details</h3>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Contact 1"
                                        name="contact1">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Number 1"
                                        name="number1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Contact 2"
                                        name="contact2">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Number 2"
                                        name="number2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Contact 3"
                                        name="contact3">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control mt-3" placeholder="Number 3"
                                        name="number3">
                                </div>
                            </div>
                            <input type="text" class="form-control mt-3" placeholder="Landlord Name"
                                name="landlord_name">
                            <input type="text" class="form-control mt-3" placeholder="Bank" name="bank">
                            <input type="text" class="form-control mt-3" placeholder="Bank account"
                                name="bank_account">
                            <textarea name="remark" class="form-control mt-3" placeholder="Remark" id="remark" cols="30"
                                rows="5"></textarea>
                            <button type="submit" name="submit"
                                class="btn btn-block font-weight-bold log_btn btn-lg mt-4">SUBMIT</button>
                        </div>
                        <div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-4"
                            style="display: none;">
                            <h3>FTOD</h3>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p class="m-0 mt-3">Facilities</p>
                                    <select name="facilities[]" multiple="multiple" id="facilitiesSelect">
                                        @foreach ($facilities as $facility)
                                            <option value="{{ $facility }}">
                                                {{ $facility }}
                                            </option>
                                        @endforeach
                                        {{-- <option value="Carpark 車場">Carpark 車場</option>
                                    <option value="Convenient 近地鐵">Convenient 近地鐵</option>
                                    <option value="H.celling高樓底">H.celling高樓底</option>
                                    <option value="Lobby 冷氣大堂">Lobby 冷氣大堂</option>
                                    <option value="Sunlight 揚窗">Sunlight 揚窗</option>
                                    <option value="Toilet 內厠">Toilet 內厠</option>
                                    <option value="Heater 熱水爐">Heater 熱水爐</option>
                                    <option value="Sink 鋅盤">Sink 鋅盤</option>
                                    <option value="Electrical 大電">Electrical 大電</option>
                                    <option value="Wide door 闊門">Wide door 闊門</option>
                                    <option value="Ekey 密碼鎖">Ekey 密碼鎖</option>
                                    <option value="Bricked 磗牆">Bricked 磗牆</option>
                                    <option value="Free wifi 送上網">Free wifi 送上網</option>
                                    <option value="Room 有房">Room 有房</option>
                                    <option value="Roof bal天台露台">Roof bal天台露台</option>
                                    <option value="Shop 地舖">Shop 地舖</option>
                                    <option value="Public Shower 公共淋浴">Public Shower 公共淋浴</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p class="m-0 mt-3">Types</p>
                                    <select name="types[]" multiple="multiple" id="typesSelect"
                                        data-parsley-multiple="types[]">
                                        @foreach ($types as $type)
                                            <option value="{{ $type }}">
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                        {{-- <option value="Rent 放租">Rent 放租</option>
                                    <option value="Sales 放售">Sales 放售</option>
                                    <option value="Subdivided 分間">Subdivided 分間</option>
                                    <option value="Independent 獨立單位">Independent 獨立單位</option>
                                    <option value="Development 發展商">Development 發展商</option>
                                    <option value="Office 寫字樓">Office 寫字樓</option>
                                    <option value="Warehouse 倉庫">Warehouse 倉庫</option>
                                    <option value="Overnight 過夜">Overnight 過夜</option>
                                    <option value="Upstairs shop 樓上舖">Upstairs shop 樓上舖</option>
                                    <option value="Party room 派對房">Party room 派對房</option>
                                    <option value="Band 夾">Band 夾</option>
                                    <option value="Class 有聲教班">Class 有聲教班</option>
                                    <option value="Class 一般教班">Class 一般教班</option>
                                    <option value="Bakery 烘焙">Bakery 烘焙</option>
                                    <option value="Photos 攝影">Photos 攝影</option>
                                    <option value="Restaurant 餐廳">Restaurant 餐廳</option> --}}
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p class="m-0 mt-3">Decoration</p>
                                    <select id="decorationsSelect" name="decorations[]" multiple="multiple">
                                        @foreach ($decorations as $decoration)
                                            <option value="{{ $decoration }}">
                                                {{ ucfirst($decoration) }}
                                            </option>
                                        @endforeach
                                        {{-- <option value="budget">Budget</option>
                                    <option value="basic">Basic</option>
                                    <option value="luxury">Luxury</option>
                                    <option value="classic">Classic</option>
                                    <option value="chill">Chill</option>
                                    <option value="grand">Grand</option>
                                    <option value="modern">Modern</option>
                                    <option value="premium">Premium</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="m-0 mt-3">用途 Usage</p>
                                    <select id="usageSelect" name="usage[]" multiple="multiple">
                                        @foreach ($usage as $use)
                                            <option value="{{ $use }}">
                                                {{ $use }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <p class="mt-3">Youtube Links</p>
                            <div class="row">
                                <div class="col-12">
                                    <label>L1</label>
                                    <input id="link" type="text" class="form-control" name="yt_link_1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label>L2</label>
                                    <input type="text" class="form-control" name="yt_link_2">
                                </div>
                            </div>
                            <p class="mt-3">Options</p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="checkbox" id="new_site新場" class="mt-2" name="options[0]"
                                                value="New site 新場" data-parsley-multiple="options">
                                            <label class="font-weight-bold ml-1" for="new_site新場">New site 新場</label>
                                        </div>
                                        <div class="col-6" id="new_site新場_section" style="display: none;">
                                            <input type="date" name="option_date[]" id="site_date"
                                                class="form-control">
                                            <textarea name="option_free_formate[]" id="site_free_formate" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="checkbox" id="Bargain_筍盤" class="mt-2" name="options[1]"
                                                value="Bargain 筍盤" data-parsley-multiple="options">
                                            <label class="font-weight-bold ml-1" for="Bargain_筍盤">Bargain 筍盤</label>
                                        </div>
                                        <div class="col-6" id="Bargain_筍盤_section" style="display: none;">
                                            <input type="date" name="option_date[]" id="bargain_date"
                                                class="form-control">
                                            <textarea name="option_free_formate[]" id="bargain_free_formate" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="checkbox" id="Discounted_減價中" class="mt-2" name="options[2]"
                                                value="Discounted 減價中" data-parsley-multiple="options">
                                            <label class="font-weight-bold ml-1" for="Discounted_減價中">Discounted
                                                減價中</label>
                                        </div>
                                        <div class="col-6" id="Discounted_減價中_section" style="display: none;">
                                            <input type="date" name="option_date[]" id="discounted_date"
                                                class="form-control">
                                            <textarea name="option_free_formate[]" id="discounted_free_formate" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="checkbox" id="Recommend_推薦" class="mt-2" name="options[3]"
                                                value="Recommend 推薦" data-parsley-multiple="options">
                                            <label class="font-weight-bold ml-1" for="Recommend_推薦">Recommend 推薦</label>
                                        </div>
                                        <div class="col-6" id="Recommend_推薦_section" style="display: none;">
                                            <input type="date" name="option_date[]" id="recommend_date"
                                                class="form-control">
                                            <textarea name="option_free_formate[]" id="recommend_free_formate" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="checkbox" id="ready_to_listing_就吉" class="mt-2"
                                                name="options[4]" value="Ready to listing 就吉"
                                                data-parsley-multiple="options">
                                            <label class="font-weight-bold ml-1" for="ready_to_listing_就吉">Ready to
                                                listing 就吉</label>
                                        </div>
                                        <div class="col-6" id="ready_to_listing_就吉_section" style="display: none;">
                                            <input type="date" name="option_date[]" id="listing_date"
                                                class="form-control">
                                            <textarea name="option_free_formate[]" id="listing_free_formate" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="checkbox" id="new_released_剛吉" class="mt-2" name="options[5]"
                                                value="New Released 剛吉" data-parsley-multiple="options">
                                            <label class="font-weight-bold ml-1" for="new_released_剛吉">New Released
                                                剛吉</label>
                                        </div>
                                        <div class="col-6" id="new_released_剛吉_section" style="display: none;">
                                            <input type="date" name="option_date[]" id="released_date"
                                                class="form-control">
                                            <textarea name="option_free_formate[]" id="released_free_formate" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-5"></div>
                            <button type="submit" name="submit"
                                class="btn btn-block font-weight-bold log_btn btn-lg last_sub">SUBMIT</button>
                        </div>
                        <div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6"
                            style="display: none;">
                            <h3>Size/Price</h3>
                            <div class="row">
                                <div class="col-6 d-flex">
                                    <label for="" class="font-weight-bold">Gross Sf: </label>
                                    <input type="number" name="gross_sf" step="0.01" class="form-control"
                                        id="gross_sf">
                                </div>
                                <div class="col-6 d-flex">
                                    <label for="" class="font-weight-bold">Net Sf: </label>
                                    <input type="number" name="net_sf" step="0.01" class="form-control"
                                        id="net_sf">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex">
                                    <label for="" class="font-weight-bold mr-1">Selling Price (M):</label>
                                    <input type="number" name="selling" step="0.01" class="form-control"
                                        id="selling">
                                </div>
                                <div class="col-6 d-flex">
                                    <label for="" class="font-weight-bold mt-2 mr-2">G@</label>
                                    <input type="number" name="selling_g" step="0.01" class="form-control"
                                        id="selling_g" readonly="">
                                </div>
                                <div class="col-6 d-flex">
                                    <label for="" class="font-weight-bold mt-2 mr-2">N@</label>
                                    <input type="number" name="selling_n" step="0.01" class="form-control"
                                        id="selling_n" readonly="">
                                </div>
                            </div>
                            <div class="container">
                                <hr>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex">
                                    <label for="" class="font-weight-bold mr-1">Rental Price:</label>
                                    <input type="number" name="rental" step="0.01" class="form-control"
                                        id="rental">
                                </div>
                                <div class="col-6 d-flex">
                                    <label for="" class="font-weight-bold mt-2 mr-2">G@</label>
                                    <input type="number" name="rental_g" step="0.01" class="form-control"
                                        id="rental_g">
                                </div>
                                <div class="col-6 d-flex">
                                    <label for="" class="font-weight-bold mt-2 mr-2">N@</label>
                                    <input type="number" name="rental_n" step="0.01" class="form-control"
                                        id="rental_n">
                                </div>
                            </div>
                            <div class="container">
                                <hr>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12 d-flex ">
                                    <label for="" class="font-weight-bold mr-2 mt-2">Mgmf: </label>
                                    <input type="text" class="form-control" name="mgmf" id="mgmf">

                                </div>
                                <div class="col-12 d-flex mt-2">
                                    <label for="" class="font-weight-bold mr-2 mt-2">Rate: </label>
                                    <input type="text" class="form-control" name="rate" id="rate">

                                </div>
                                <div class="col-12 d-flex mt-2">
                                    <label for="" class="font-weight-bold mr-2 mt-2">Land: </label>
                                    <input type="text" class="form-control" name="land" id="land">

                                </div>
                                <div class="col-12 d-flex mt-2">
                                    <label for="" class="font-weight-bold mr-2 mt-2">Oths: </label>
                                    <input type="text" class="form-control" name="oths" id="oths">

                                </div>
                            </div>

                            <button type="submit" name="submit"
                                class="btn btn-block font-weight-bold log_btn btn-lg last_sub mt-5">SUBMIT</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- </form> -->
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript">
    </script>

    <script src="{{ asset('assets/multi-select/multiselect.js') }}"></script>
    <!-- include FilePond library -->
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <!-- include FilePond plugins -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

    <!-- include FilePond jQuery adapter -->
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <script src="{{ asset('assets/parsley-plugin/script.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Prevent typing restricted characters
            $('#code').on('input', function() {
                let invalidChars = /[#\/\\?]/g; // regex for restricted chars
                if (invalidChars.test(this.value)) {
                    this.value = this.value.replace(invalidChars, ''); // remove them
                }
            });

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

        // document.addEventListener('DOMContentLoaded', function () {
        //     FilePond.registerPlugin(FilePondPluginImagePreview);

        //     var tempId = $('#tempId').val();

        //     FilePond.create(document.querySelector('.filepond'), {
        //         allowMultiple: true,
        //         allowReorder: true,
        //         server: {
        //             process: {
        //                 url: '/upload-images',
        //                 method: 'POST',
        //                 headers: {
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //                 },
        //                 ondata: (formData) => {
        //                     formData.append('temp_id', tempId);
        //                     return formData;
        //                 },
        //                 onerror: (response) => {
        //                     console.error('File upload error:', response);
        //                     alert('Failed to upload file. Please try again.');
        //                 }
        //             },
        //             revert: {
        //                 url: '/delete-image',
        //                 method: 'DELETE',
        //                 headers: {
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //                 },
        //                 onerror: (response) => {
        //                     console.error('Error during file revert:', response);
        //                     alert('Failed to delete file. Please try again.');
        //                 }
        //             }
        //         },
        //         onerror: (error) => {
        //             console.error('FilePond error:', error);
        //         },
        //     });
        // });
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            var tempId = $('#tempId').val();
            var submitButtons = document.querySelectorAll('button[type="submit"]');
            var totalFiles = 0;
            var uploadedFiles = 0;

            var filePondInstance = FilePond.create(document.querySelector('.filepond'), {
                allowMultiple: true,
                allowReorder: true,
                server: {
                    process: {
                        url: '/upload-images',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        ondata: (formData) => {
                            formData.append('temp_id', tempId);
                            return formData;
                        },
                        onerror: (response) => {
                            console.error('File upload error:', response);
                            alert('Failed to upload file. Please try again.');
                        }
                    },
                    revert: {
                        url: '/delete-image',
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        onerror: (response) => {
                            console.error('Error during file revert:', response);
                            alert('Failed to delete file. Please try again.');
                        }
                    }
                },
                onerror: (error) => {
                    console.error('FilePond error:', error);
                },
            });

            filePondInstance.on('addfile', (file) => {
                totalFiles++;
                updateButtonText();
            });

            filePondInstance.on('processfile', (file) => {
                updateButtonText();
                disableSubmitButtons();
            });

            filePondInstance.on('processfileprogress', (file, progress) => {
                if (progress === 1) {
                    uploadedFiles++;
                    updateButtonText();
                }
            });

            filePondInstance.on('processfile', (file) => {
                if (uploadedFiles === totalFiles) {
                    enableSubmitButtons();
                    updateButtonText();
                }
            });

            function updateButtonText() {
                submitButtons.forEach(button => {
                    if (totalFiles > 0 && uploadedFiles < totalFiles) {
                        button.textContent = `Uploading. ${totalFiles - uploadedFiles} Left`;
                    } else {
                        button.textContent = 'Submit';
                    }
                });
            }

            // Function to disable the submit button
            function disableSubmitButtons() {
                submitButtons.forEach(button => {
                    button.disabled = true;
                });
            }

            // Function to enable the submit button
            function enableSubmitButtons() {
                submitButtons.forEach(button => {
                    button.disabled = false;
                });
            }
        });

        $(document).ready(function() {
            var activeTab = localStorage.getItem('activeTab') || 0;

            $('#smartwizard').smartWizard({
                selected: parseInt(activeTab),
                theme: 'arrows',
                transition: {
                    animation: 'slide-horizontal',
                },
                showStepURLhash: false,
                autoAdjustHeight: false,
                anchorSettings: {
                    enableAllAnchors: true,
                    anchorClickable: true
                }
            });

            $('.sw>.nav .nav-link').on('click', function(e) {
                e.preventDefault();
                const stepIndex = $(this).parent().index();
                $('#smartwizard').smartWizard("goToStep", stepIndex);
            });

            // var activeColor = '#5bc0de';
            var activeColor = '#1976D2';
            var doneColor = '#5cb85c';
            var nonActiveTextColor = '#007bff';

            function updateTabColors() {
                $('#smartwizard .nav-link').each(function() {
                    if ($(this).hasClass('done')) {
                        // Apply done color using CSS variable override
                        $(this).css({
                            'background-color': 'gray',
                            'color': 'white',
                            'border-left': 'none',
                            '--sw-anchor-done-primary-color': doneColor // Set the CSS variable here
                        });
                        $(this).find('.sw-icon').css({
                            'color': doneColor // Green arrow for done tabs
                        });
                    } else if ($(this).hasClass('active')) {
                        $(this).css({
                            'background-color': activeColor,
                            '--sw-anchor-active-primary-color': activeColor,
                            'color': 'white',
                            'border-left': 'none'
                        });
                        $(this).find('.sw-icon').css({
                            'color': 'white'
                        });
                    } else {
                        $(this).css({
                            'background-color': 'transparent',
                            'color': nonActiveTextColor,
                            'border-left': 'none'
                        });
                        $(this).find('.sw-icon').css({
                            'color': 'transparent'
                        });
                    }
                });
            }

            updateTabColors();

            $('#smartwizard').on("showStep", function(e, anchorObject, stepIndex) {
                localStorage.setItem('activeTab', stepIndex);
                updateTabColors();
            });
        });

        $('select[multiple]').multiselect({
            columns: 1,
            placeholder: 'Select',
            search: true,
            searchOptions: {
                'default': 'Search'
            },
            selectAll: true
        });

        $(document).ready(function() {
            // Toggle visibility based on checkbox state
            $('#new_site新場').change(function() {
                $('#new_site新場_section').toggle(this.checked);
            });

            $('#Bargain_筍盤').change(function() {
                $('#Bargain_筍盤_section').toggle(this.checked);
            });

            $('#Discounted_減價中').change(function() {
                $('#Discounted_減價中_section').toggle(this.checked);
            });

            $('#Recommend_推薦').change(function() {
                $('#Recommend_推薦_section').toggle(this.checked);
            });

            $('#ready_to_listing_就吉').change(function() {
                $('#ready_to_listing_就吉_section').toggle(this.checked);
            });

            $('#new_released_剛吉').change(function() {
                $('#new_released_剛吉_section').toggle(this.checked);
            });
        });

        // size/price calculate
        $(document).ready(function() {
            $('#gross_sf').keyup(function(e) {
                let arr = layer();
                let sell = $('#selling').val() ? parseFloat($('#selling').val() * 1000000) : 0;
                let rental = $('#rental').val() ? parseFloat($('#rental').val()) : 0;

                var calArray = calculationFunction(arr[0], arr[1], sell);
                $('#selling_g').val(calArray[0]);
                $('#selling_n').val(calArray[1]);
                var calArray = calculationFunction(arr[0], arr[1], rental);
                $('#rental_g').val(calArray[0]);
                $('#rental_n').val(calArray[1]);
            });

            $('#rental_g').keyup(function(e) {
                let arr = layer();
                $('#rental').val(arr[0] * $(this).val())
            });

            $('#rental_n').keyup(function(e) {
                let arr = layer();
                $('#rental').val(arr[1] * $(this).val())
            });

            $('#net_sf').keyup(function(e) {
                let arr = layer();
                let sell = $('#selling').val() ? parseFloat($('#selling').val() * 1000000) : 0;
                let rental = $('#rental').val() ? parseFloat($('#rental').val()) : 0;

                var calArray = calculationFunction(arr[0], arr[1], sell);
                $('#selling_g').val(calArray[0]);
                $('#selling_n').val(calArray[1]);
                var calArray = calculationFunction(arr[0], arr[1], rental);
                $('#rental_g').val(calArray[0]);
                $('#rental_n').val(calArray[1]);
            });
            $('#selling').keyup(function(e) {
                let arr = layer();
                let sell = $('#selling').val() ? parseFloat($('#selling').val() * 1000000) : 0;
                let calArray = calculationFunction(arr[0], arr[1], sell);
                $('#selling_g').val(calArray[0]);
                $('#selling_n').val(calArray[1]);
            });
            $('#rental').keyup(function(e) {
                let arr = layer();
                let rental = $('#rental').val() ? parseFloat($('#rental').val()) : 0;
                let calArray = calculationFunction(arr[0], arr[1], rental);
                $('#rental_g').val(calArray[0]);
                $('#rental_n').val(calArray[1]);
            });

            function layer() {
                let a = $('#gross_sf').val() ? parseFloat($('#gross_sf').val()) : 0;
                let b = $('#net_sf').val() ? parseFloat($('#net_sf').val()) : 0;
                return [a, b];
            }


            function calculationFunction(a, b, main) {
                console.log(a)
                console.log(b)
                console.log(main)
                let G = parseFloat(main / a).toFixed(2);
                let N = parseFloat(main / b).toFixed(2);
                return [G, N];
            }

        });
    </script>
@endsection
