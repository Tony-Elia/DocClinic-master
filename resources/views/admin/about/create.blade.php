@extends('layouts.admin.layout')
@section('title','About')
@section('admin-content')
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">About Form</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="about_image">About Image</label>
                                    <input type="file" class="form-control" name="about_image" id="about_image">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mission_image">Mission Image</label>
                                    <input type="file" class="form-control" name="mission_image" id="mission_image">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vision_image">vision Image</label>
                                    <input type="file" class="form-control" name="vision_image" id="vision_image">
                                </div>
                            </div>



                        </div>

                        <div class="form-group">
                            <label for="sort_description">Sort Description</label>
                            <textarea class="form-control" cols="30" rows="5" id="sort_description" name="sort_description" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="about_description">About Description</label>
                            <textarea class="summernote" id="about_description" name="about_description"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="mission_description">Mission Description</label>
                            <textarea class="summernote" id="mission_description" name="mission_description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="vision_description">Vision Description</label>
                            <textarea class="summernote" id="vision_description" name="vision_description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Save About</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
