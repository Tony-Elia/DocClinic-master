@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','blog')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.blog.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','all_blog')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','blog_form')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">{{ $websiteLang->where('lang_key','title')->first()->custom_lang }}</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="category">{{ $websiteLang->where('lang_key','cat')->first()->custom_lang }}</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">{{ $websiteLang->where('lang_key','select_cat')->first()->custom_lang }}</option>
                                @foreach ($categories as $item)
                                <option {{ old('category')==$item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">{{ $websiteLang->where('lang_key','img')->first()->custom_lang }}</label>
                            <div><input type="file" name="image" id="image"></div>
                        </div>
                        <div class="form-group">
                            <label for="sort_description">{{ $websiteLang->where('lang_key','short_des')->first()->custom_lang }}</label>
                            <textarea name="sort_description" id="sort_description" cols="30" rows="5" class="form-control">{{ old('sort_description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="description">{{ $websiteLang->where('lang_key','des')->first()->custom_lang }}</label>
                            <textarea class="summernote" id="description" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ $websiteLang->where('lang_key','status')->first()->custom_lang }}</label>
                                    <select name="status" id="status" class="form-control">
                                        <option  value="1">{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}</option>
                                        <option  value="0">{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="show_feature_blog">{{ $websiteLang->where('lang_key','show_featured')->first()->custom_lang }}</label>
                                    <select name="show_feature_blog" id="show_feature_blog" class="form-control">
                                        <option {{ old('show_feature_blog')==0 ? 'selected': '' }} value="0">{{ $websiteLang->where('lang_key','no')->first()->custom_lang }}</option>
                                        <option {{ old('show_feature_blog')==1 ? 'selected': '' }} value="1">{{ $websiteLang->where('lang_key','yes')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="seo_title">{{ $websiteLang->where('lang_key','seo_title')->first()->custom_lang }}</label>
                            <input type="text" name="seo_title" class="form-control" id="seo_title" value="{{ old('seo_title') }}">
                        </div>
                        <div class="form-group">
                            <label for="seo_description">{{ $websiteLang->where('lang_key','seo_des')->first()->custom_lang }}</label>
                            <textarea name="seo_description" id="seo_description" cols="30" rows="3" class="form-control" >{{ old('seo_description') }}</textarea>
                        </div>


                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','save')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
