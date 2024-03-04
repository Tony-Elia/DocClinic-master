@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','tawk_live')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','tawk_live')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.update.livechat.setting') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="">{{ $websiteLang->where('lang_key','tawk_live')->first()->custom_lang }}</label>
                            <select name="live_chat" id="" class="form-control">
                                <option {{ $setting->live_chat==1 ? 'selected':'' }} value="1">{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}</option>
                                <option {{ $setting->live_chat==0 ? 'selected':'' }} value="0">{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="livechat_script">{{ $websiteLang->where('lang_key','chat_link')->first()->custom_lang }}</label>
							<input type="text" class="form-control" name="livechat_script" id="livechat_script" value="{{ $setting->livechat_script }}">
                        </div>
                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
