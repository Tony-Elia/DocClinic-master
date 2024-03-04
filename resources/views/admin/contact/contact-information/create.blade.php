@extends('layouts.admin.layout')
@section('title','Contact-Information')
@section('admin-content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contact-information.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="header">Contact Header</label>
                                    <input type="text" name="header" class="form-control" id="header"  value="{{ old('header') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" class="form-control" id="address"  value="{{ old('address') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Contact Description</label>
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control" >{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="about">Footer About</label>
                                    <textarea name="about" id="about" cols="30" rows="3" class="form-control" >{{ old('about') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phones">Contact Phones</label>
                                    <textarea name="phones" id="phones" cols="30" rows="3" class="form-control" >{{ old('phones') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emails">Contact Emails</label>
                                    <textarea name="emails" id="emails" cols="30" rows="3" class="form-control" >{{ old('emails') }}</textarea>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="map_embed_code">Google Map Embed Code</label>
                                    <textarea name="map_embed_code" id="map_embed_code" class="form-control" cols="30" rows="5" >{{ old('map_embed_code') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Save Contact</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
