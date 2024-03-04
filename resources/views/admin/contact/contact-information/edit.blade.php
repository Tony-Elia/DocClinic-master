@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','contact_info')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','contact_info')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contact-information.update',$contact->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="header">{{ $websiteLang->where('lang_key','contact_header')->first()->custom_lang }}</label>
                                    <input type="text" name="header" class="form-control" id="header"  value="{{ $contact->header }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">{{ $websiteLang->where('lang_key','address')->first()->custom_lang }}</label>
                                    <textarea name="address" id="address" cols="30" rows="3" class="form-control" >{{ $contact->address }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">{{ $websiteLang->where('lang_key','contact_des')->first()->custom_lang }}</label>
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control" >{{ $contact->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="about">{{ $websiteLang->where('lang_key','footer_about')->first()->custom_lang }}</label>
                                    <textarea name="about" id="about" cols="30" rows="3" class="form-control" >{{ $contact->about }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phones">{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }}</label>
                                    <textarea name="phones" id="phones" cols="30" rows="3" class="form-control" >{{ $contact->phones }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="emails">{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</label>
                                    <textarea name="emails" id="emails" cols="30" rows="3" class="form-control" >{{ $contact->emails }}</textarea>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="map_embed_code">{{ $websiteLang->where('lang_key','google_map')->first()->custom_lang }}</label>
                                    <textarea name="map_embed_code" id="map_embed_code" class="form-control" cols="30" rows="5" >{{ $contact->map_embed_code }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="emails">{{ $websiteLang->where('lang_key','copyright')->first()->custom_lang }}</label>
                                    <input type="text" name="copyright" class="form-control" id="copyright"  value="{{ $contact->copyright }}">
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
