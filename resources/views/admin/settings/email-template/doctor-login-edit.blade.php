@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','email_template')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
<a href="{{ route('admin.email.template') }}" class="btn btn-success mb-2"><i class="fas fa-backward" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','go_back')->first()->custom_lang }}</a>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>{{ $websiteLang->where('lang_key','variable')->first()->custom_lang }}</th>
                            <th>{{ $websiteLang->where('lang_key','meaning')->first()->custom_lang }}</th>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                    $name="{{doctor_name}}";
                                @endphp
                                <td>{{ $name }}</td>
                                <td>{{ $websiteLang->where('lang_key','doctor_name')->first()->custom_lang }}</td>
                            </tr>
                            <tr>
                                @php
                                    $doctor_email="{{email}}";
                                @endphp
                                <td>{{ $doctor_email }}</td>
                                <td>{{ $websiteLang->where('lang_key','doctor_email')->first()->custom_lang }}</td>
                            </tr>
                            <tr>
                                @php
                                    $password="{{password}}";
                                @endphp
                                <td>{{ $password }}</td>
                                <td>{{ $websiteLang->where('lang_key','doc_pass')->first()->custom_lang }}</td>
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

