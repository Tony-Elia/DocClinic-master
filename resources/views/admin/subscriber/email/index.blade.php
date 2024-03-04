@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','email_for_sub')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','email_for_sub')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.send.subscriber.mail') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">{{ $websiteLang->where('lang_key','subject')->first()->custom_lang }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="">{{ $websiteLang->where('lang_key','msg')->first()->custom_lang }} <span class="text-danger">*</span></label>
                            <textarea name="message" cols="30" rows="10" class="form-control summernote"></textarea>
                        </div>

                        <button class="btn btn-success" type="submit">{{ $websiteLang->where('lang_key','send_email')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

