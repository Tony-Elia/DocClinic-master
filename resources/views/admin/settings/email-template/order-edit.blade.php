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
                                    $name="{{patient_name}}";
                                @endphp
                                <td>{{ $name }}</td>
                                <td>{{ $websiteLang->where('lang_key','patient_name')->first()->custom_lang }}</td>
                            </tr>

                            <tr>
                                @php
                                    $orderId="{{orderId}}";
                                @endphp
                                <td>{{ $orderId }}</td>
                                <td>{{ $websiteLang->where('lang_key','order_id')->first()->custom_lang }}</td>
                            </tr>

                            <tr>
                                @php
                                    $payment_method="{{payment_method}}";
                                @endphp
                                <td>{{ $payment_method }}</td>
                                <td>{{ $websiteLang->where('lang_key','payment_method')->first()->custom_lang }}</td>
                            </tr>
                            <tr>
                                @php
                                    $amount="{{amount}}";
                                @endphp
                                <td>{{ $amount }}</td>
                                <td>{{ $websiteLang->where('lang_key','amount')->first()->custom_lang }}</td>
                            </tr>
                            <tr>
                                @php
                                    $order_details="{{order_details}}";
                                @endphp
                                <td>{{ $order_details }}</td>
                                <td>{{ $websiteLang->where('lang_key','order_detail')->first()->custom_lang }}</td>
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
                            <label for="">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $email->subject }}" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="">Description <span class="text-danger">*</span></label>
                            <textarea name="description" cols="30" rows="10" class="form-control summernote">{{ $email->description }}</textarea>

                        </div>

                        <button class="btn btn-success" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

