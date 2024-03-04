@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','blog_comment')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','blog_comment')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update.comment.setting') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">{{ $websiteLang->where('lang_key','comment_type')->first()->custom_lang }}</label>
                            <select name="comment_type" id="" class="form-control">
                                <option {{ $setting->comment_type==1 ? 'selected':'' }} value="1">{{ $websiteLang->where('lang_key','custom_comment')->first()->custom_lang }}</option>
                                <option {{ $setting->comment_type==0 ? 'selected':'' }} value="0">{{ $websiteLang->where('lang_key','facebook_comment')->first()->custom_lang }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="facebook_comment_script">{{ $websiteLang->where('lang_key','fb_app_id')->first()->custom_lang }}</label>
							<input type="text" class="form-control" name="facebook_comment_script" id="facebook_comment_script" value="{{ $setting->facebook_comment_script }}">
                        </div>
                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
