@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.doctor.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','all_doc')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','doc_form')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.doctor.update',$doctor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }} *</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ $doctor->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ $websiteLang->where('lang_key','email')->first()->custom_lang }} *</label>
                                    <input type="text" name="email" class="form-control" id="email" value="{{ $doctor->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }} *</label>
                                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $doctor->phone }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="designations">{{ $websiteLang->where('lang_key','designation')->first()->custom_lang }} *</label>
                                    <input type="text" name="designations" class="form-control" id="designations" value="{{ $doctor->designations }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">{{ $websiteLang->where('lang_key','img')->first()->custom_lang }}</label>
                                    <input type="file" name="image" class="form-control" id="image" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">{{ $websiteLang->where('lang_key','exist_img')->first()->custom_lang }}</label>
                                    <img src="{{ url($doctor->image) }}" alt="doctor image" width="120px">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="appointment_fee">{{ $websiteLang->where('lang_key','fee')->first()->custom_lang }} *</label>
                                    <input type="text" name="appointment_fee" class="form-control" id="appointment_fee"  value="{{ $doctor->fee }}">
                                </div>
                            </div>




                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="department">{{ $websiteLang->where('lang_key','dep')->first()->custom_lang }} *</label>
                                    <select name="department" id="department" class="form-control">
                                        <option value="">{{ $websiteLang->where('lang_key','select_dep')->first()->custom_lang }}</option>
                                        @foreach ($departments as $item)
                                        <option {{ $doctor->department_id==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="location">{{ $websiteLang->where('lang_key','location')->first()->custom_lang }} *</label>
                                    <select name="location" id="location" class="form-control">
                                        <option value="">{{ $websiteLang->where('lang_key','select_loc')->first()->custom_lang }}</option>
                                        @foreach ($locations as $item)
                                        <option {{ $doctor->location_id==$item->id? 'selected' : ''}} value="{{ $item->id }}">{{ ucfirst($item->location) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="facebook">{{ $websiteLang->where('lang_key','facebook')->first()->custom_lang }}</label>
                                    <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $doctor->facebook }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="twitter">{{ $websiteLang->where('lang_key','twitter')->first()->custom_lang }}</label>
                                    <input type="text" class="form-control" name="twitter" id="twitter" value="{{ $doctor->twitter }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="linkedin">{{ $websiteLang->where('lang_key','linkedin')->first()->custom_lang }}</label>
                                    <input type="text" class="form-control" name="linkedin" id="linkedin" value="{{ $doctor->linkedin }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="about">{{ $websiteLang->where('lang_key','about')->first()->custom_lang }}</label>
                                    <textarea name="about" id="about" cols="30" rows="5" class="form-control">{{ $doctor->about }}</textarea>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">{{ $websiteLang->where('lang_key','address')->first()->custom_lang }}</label>
                                    <textarea name="address" id="address" class="summernote">{{ $doctor->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="educations">{{ $websiteLang->where('lang_key','education')->first()->custom_lang }}</label>
                                    <textarea name="educations" id="educations" class="summernote">{{ $doctor->educations }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="experiences">{{ $websiteLang->where('lang_key','experience')->first()->custom_lang }}</label>
                                    <textarea name="experiences" id="experiences" class="summernote">{{ $doctor->experience }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="qualifications">{{ $websiteLang->where('lang_key','qualification')->first()->custom_lang }}</label>
                                    <textarea name="qualifications" id="qualifications" class="summernote">{{ $doctor->qualifications }}</textarea>
                                </div>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ $websiteLang->where('lang_key','status')->first()->custom_lang }} *</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $doctor->status==1 ? 'selected':'' }} value="1">{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}</option>
                                        <option {{ $doctor->status==0 ? 'selected':'' }} value="0">{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="show_homepage">{{ $websiteLang->where('lang_key','show_homepage')->first()->custom_lang }} *</label>
                                    <select name="show_homepage" id="show_homepage" class="form-control">
                                        <option {{ $doctor->show_homepage==0 ? 'selected':'' }} value="0">{{ $websiteLang->where('lang_key','no')->first()->custom_lang }}</option>
                                        <option {{ $doctor->show_homepage==1 ? 'selected':'' }}  value="1">{{ $websiteLang->where('lang_key','yes')->first()->custom_lang }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="seo_title">{{ $websiteLang->where('lang_key','seo_title')->first()->custom_lang }}</label>
                                    <input type="text" name="seo_title" class="form-control" id="seo_title" value="{{ $doctor->seo_title }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="seo_description">{{ $websiteLang->where('lang_key','seo_des')->first()->custom_lang }}</label>
                                    <textarea name="seo_description" id="seo_description" cols="30" rows="3" class="form-control" >{{ $doctor->seo_description }}</textarea>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
