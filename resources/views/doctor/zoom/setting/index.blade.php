@extends('layouts.doctor.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','zoom_setting')->first()->custom_lang }}</title>
@endsection
@section('doctor-content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','zoom_setting')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                    @if (!$credential)
                    <form action="{{ route('doctor.store-zoom-credential') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="zoom_api_key">{{ $websiteLang->where('lang_key','client_id')->first()->custom_lang }}</label>
                            <input type="text" class="form-control" name="zoom_api_key" id="zoom_api_key">
                        </div>



                        <div class="form-group">
                            <label for="zoom_api_secret">{{ $websiteLang->where('lang_key','client_secret')->first()->custom_lang }}</label>
                            <input type="text" class="form-control" name="zoom_api_secret" id="zoom_api_secret">
                        </div>


                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','save')->first()->custom_lang }}</button>
                    </form>
                    @else
                        <form action="{{ route('doctor.update-zoom-credential',$credential->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="zoom_api_key">{{ $websiteLang->where('lang_key','client_id')->first()->custom_lang }}</label>
                                <input type="text" class="form-control" name="zoom_api_key" id="zoom_api_key" value="{{ $credential->zoom_api_key }}">
                            </div>



                            <div class="form-group">
                                <label for="zoom_api_secret">{{ $websiteLang->where('lang_key','client_secret')->first()->custom_lang }}</label>
                                <input type="text" class="form-control" name="zoom_api_secret" id="zoom_api_secret" value="{{ $credential->zoom_api_secret }}">
                            </div>


                            <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
