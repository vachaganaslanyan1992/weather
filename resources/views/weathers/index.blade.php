@extends('layouts.app')
@push('head')
    <link href="{{ asset('assets/weathers/css/main.css') }}" rel="stylesheet">
@endpush
@push('foot')
    <script src="{{ asset('assets/weathers/js/main.js') }}"></script>
@endpush
@section('title', 'Weather')

@section('content')

    <div class="container-fluid dn">
        <div class="row">
            <div class="col-6">
                <div class="row pr">
                    <div class="col-lg-12 pa countries-list">
                        <select id="cities" class="selectpicker" data-live-search="true" name="city">
                            @foreach($cites as $city)
                                <option value="{{$city->code}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 selected-city"></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 fs-18 opacity-3 change-city">Change city</div>
                    <div class="col-lg-6 fs-18 opacity-3 current-location">
                        <i><img class="location-image" src="/resources/images/location.png" alt="location"></i>
                        My location
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-right">
                º
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" value="c" class="deg" name="deg" autocomplete="off" checked>C
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" value="f" class="deg" name="deg" autocomplete="off">F
                    </label>
                </div>
            </div>
        </div>

        <div class="row mt-190 text-center">
            <div class="col-12 fs-180">
                <i class="weather-icon"><img src="" alt="weather"></i><span class="temperature"></span>º
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 offset-lg-4 fs-25 text-center temperature-description"></div>
        </div>

        <div class="row mt-218">
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="weather-parameters-title opacity-3 fs-18">Wind</div>
                <div class="weather-parameters-value fs-25 wind"></div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="weather-parameters-title opacity-3 fs-18">Pressure</div>
                <div class="weather-parameters-value fs-25 pressure"></div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="weather-parameters-title opacity-3 fs-18">Humidity</div>
                <div class="weather-parameters-value fs-25 humidity"></div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-6">
                <div class="weather-parameters-title opacity-3 fs-18">Chance of rain</div>
                <div class="weather-parameters-value fs-25 chance-rain"></div>
            </div>
        </div>

    </div>
@endsection
