@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','work_section')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','work_section')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.work.update',$work->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="">{{ $websiteLang->where('lang_key','exist_img')->first()->custom_lang }}</label>
                            <img class="ml-4" src="{{ url($work->image) }}" alt="Work Bg image" width="120px">

                        </div>
                        <div class="form-group">
                            <label for="image">{{ $websiteLang->where('lang_key','img')->first()->custom_lang }}</label>
                            <input type="file" name="image" class="form-control" id="image">

                        </div>
                        <div class="form-group">
                            <label for="video">{{ $websiteLang->where('lang_key','video_link')->first()->custom_lang }}</label>
                            <input type="text" name="video" class="form-control" id="video" value="{{ $work->video }}">

                        </div>
                        <div class="form-group">
                            <label for="title">{{ $websiteLang->where('lang_key','title')->first()->custom_lang }}</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ $work->title }}">

                        </div>

                        <div class="form-group">
                            <label for="description">{{ $websiteLang->where('lang_key','des')->first()->custom_lang }}</label>
                            <textarea name="description" id="description" cols="30" rows="3" class="form-control" >{{ $work->description }}</textarea>


                        </div>
                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
