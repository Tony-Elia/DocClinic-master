@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','email_template')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
<a href="{{ route('admin.email.template') }}" class="btn btn-success mb-2"><i class="fas fa-backward" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','go_back')->first()->custom_lang }}</a>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pre Notification Email</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>{{ $websiteLang->where('lang_key','variable')->first()->custom_lang }}</th>
                            <th>{{ $websiteLang->where('lang_key','meaning')->first()->custom_lang }}</th>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $patient_name="{{patient_name}}";
                                @endphp
                                <td>{{ $patient_name }}</td>
                                <td>{{ $websiteLang->where('lang_key','patient_name')->first()->custom_lang }}</td>
                            </tr>

                            <tr>
                                @php
                                    $schedule_start_time="{{schedule}}";
                                @endphp
                                <td>{{ $schedule_start_time }}</td>
                                <td>{{ $websiteLang->where('lang_key','schedule_time')->first()->custom_lang }}</td>
                            </tr>

                            <tr>
                                @php
                                    $schedule_date="{{date}}";
                                @endphp
                                <td>{{ $schedule_date }}</td>
                                <td>S{{ $websiteLang->where('lang_key','schedule_date')->first()->custom_lang }}</td>
                            </tr>

                            <tr>
                                @php
                                    $doctor="{{doctor}}";
                                @endphp
                                <td>{{ $doctor }}</td>
                                <td>{{ $websiteLang->where('lang_key','doctor_name')->first()->custom_lang }}</td>
                            </tr>






                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">

                    <form action="{{ route('admin.email.update',$email->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">{{ $websiteLang->where('lang_key','subject')->first()->custom_lang }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $email->subject }}" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="">{{ $websiteLang->where('lang_key','des')->first()->custom_lang }} <span class="text-danger">*</span></label>
                            <textarea name="description" cols="30" rows="10" class="form-control summernote">{{ $email->description }}</textarea>

                        </div>

                        <button class="btn btn-success" type="submit">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

