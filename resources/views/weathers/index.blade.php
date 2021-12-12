@extends('layouts.app')
@push('head')
    <link href="{{ asset('assets/weathers/css/main.css') }}" rel="stylesheet">
@endpush
@push('foot')
    <script src="{{ asset('assets/weathers/js/main.js') }}"></script>
@endpush
@section('title', 'Weather')

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="row">
                <div class="col-lg-12">omsk</div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <select id="cities" class="selectpicker" data-live-search="true" name="city">
                        @foreach($cites as $city)
                            <option value="{{$city->code}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6 text-right">c</div>
    </div>

    <div class="row">
        <div class="col-lg-4 offset-lg-4 text-center">19</div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-6">asd</div>
        <div class="col-lg-3 col-sm-6 col-xs-6">asd</div>
        <div class="col-lg-3 col-sm-6 col-xs-6">asd</div>
        <div class="col-lg-3 col-sm-6 col-xs-6">asd</div>
    </div>
@endsection
