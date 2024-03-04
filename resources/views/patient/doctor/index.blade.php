@extends('layouts.patient.layout')
@section('title')
<title>{{ $title_meta->doctor_title }}</title>
@endsection
@section('meta')
<meta name="description" content="{{ $title_meta->doctor_meta_description }}">
@endsection
@section('patient-content')

<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->doctor ? url($banner->doctor) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->doctor }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->doctor }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->


<div class="doctor-search">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="s-container">
                <form action="{{ url('search-doctor') }}">

                    <div class="s-box">
                        <select name="location" class="form-control select2">
                            <option value="">{{ $websiteLang->where('lang_key','select_loc')->first()->custom_lang }}</option>
                            @foreach ($locations as $location)
                            <option {{ @$location_id==$location->id?'selected':'' }} value="{{ $location->id }}">{{ ucwords($location->location) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="s-box">
                        <select name="department" class="form-control select2">
                            <option value="">{{ $websiteLang->where('lang_key','select_dep')->first()->custom_lang }}</option>
                            @foreach ($departments as $department)
                            <option {{ @$department_id==$department->id?'selected':'' }} value="{{ $department->id }}">{{ ucwords($department->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="s-box">
                        <select name="doctor" class="form-control select2">
                            <option value="">{{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang }}</option>
                            @foreach ($doctorsForSearch as $doctor)
                            <option {{ @$doctor_id==$doctor->id?'selected':'' }} value="{{ $doctor->id }}">{{ ucwords($doctor->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="s-button">
                        <button type="submit">{{ $websiteLang->where('lang_key','search')->first()->custom_lang }}</button>
                    </div>
                </form>
                </div>

            </div>
        </div>
    </div>
</div>




<!--Service Start-->
<div class="team-page pt_40 pb_70">
    <div class="container">
        <div class="row">

            @if ($doctors->count()!=0)
            @foreach ($doctors as $doctor)
            <div class="col-lg-3 col-md-4 col-6 mt_30">
                <div class="team-item">
                    <div class="team-photo">
                        <img src="{{ url($doctor->image) }}" alt="Team Photo">
                    </div>
                    <div class="team-text">
                        <a href="{{ url('doctor-details/'.$doctor->slug) }}">{{ ucfirst($doctor->name) }}</a>
                        <p>{{ ucfirst($doctor->department->name) }}</p>
                        <p><span><i class="fas fa-graduation-cap"></i> {{ $doctor->designations }}</span></p>
                        <p><span><b><i class="fas fa-street-view"></i> {{ ucfirst($doctor->location->location) }}</b></span></p>
                    </div>
                    <div class="team-social">
                        <ul>
                            @if ($doctor->facebook)
                            <li><a href="{{ $doctor->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if ($doctor->twitter)
                            <li><a href="{{ $doctor->twitter }}"><i class="fab fa-twitter"></i></a></li>
                            @endif
                            @if ($doctor->linkedin)
                            <li><a href="{{ $doctor->linkedin }}"><i class="fab fa-linkedin"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <h3 class="text-danger text-center">{{ $websiteLang->where('lang_key','doc_not_found')->first()->custom_lang }}</h3>
            @endif


        </div>
        {{ @$doctors->links('patient.paginator') }}
    </div>
</div>
<!--Service End-->






@endsection
