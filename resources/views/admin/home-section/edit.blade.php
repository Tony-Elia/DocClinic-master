@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','home_section')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.home-section.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','all_section')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','home_section')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">

                   <form action="{{ route('admin.home-section.update',$homeSection->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    @if ($homeSection->section_type !=1)
                    <div class="row" id="section-details">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_header">{{ $websiteLang->where('lang_key','first_header')->first()->custom_lang }}</label>
                                <input type="text" class="form-control" name="first_header" id="first_header" value="{{ $homeSection->first_header }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="second_header">{{ $websiteLang->where('lang_key','second_header')->first()->custom_lang }}</label>
                                <input type="text" class="form-control" name="second_header" id="second_header" value="{{ $homeSection->second_header }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">{{ $websiteLang->where('lang_key','des')->first()->custom_lang }}</label>
                                <textarea class="form-control" cols="30" rows="5"  id="description" name="description">{{ $homeSection->description }}</textarea>
                            </div>
                        </div>
                    </div>
                @endif

                    <div class="row">
                        @if ($homeSection->section_type !=2)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="content_quantity">{{ $websiteLang->where('lang_key','content_qty')->first()->custom_lang }}</label>
                                    <input type="number" name="content_quantity" id="content_quantity" class="form-control" value="{{ $homeSection->content_quantity }}">
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="show_homepage">{{ $websiteLang->where('lang_key','show_homepage')->first()->custom_lang }}</label>
                                <select name="show_homepage" id="show_homepage" class="form-control">
                                    <option {{ $homeSection->show_homepage==1 ? 'selected':'' }} value="1">{{ $websiteLang->where('lang_key','yes')->first()->custom_lang }}</option>
                                    <option {{ $homeSection->show_homepage==0 ? 'selected':'' }} value="0">{{ $websiteLang->where('lang_key','no')->first()->custom_lang }}</option>
                                </select>
                            </div>
                            <input type="hidden" value="{{ $homeSection->section_type }}" name="section_type">
                        </div>

                    </div>


                    <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                </form>
                </div>
            </div>
        </div>
    </div>

@endsection
