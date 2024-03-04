@extends('layouts.admin.layout')
@section('title','Medicine Edit')
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.department.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> All Departments </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Department Form</h6>
                </div>
                <div class="card-body">
                   
                    <form action="{{ route('admin.department.update',$department->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $department->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thumbnail_image">Thumbnail Image</label>
                                    <input type="file" class="form-control" name="thumbnail_image" id="thumbnail_image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thumbnail_image">Old Thumbnail</label>
                                    <img src="{{ url($department->thumbnail_image) }}" alt="Department thumbnail" width="120px">
                                </div>
                            </div>


                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="summernote" id="description" name="description">{{ $department->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ $department->status ==1 ? 'selected' :'' }} value="1">Active</option>
                                        <option {{ $department->status ==0 ? 'selected' :'' }} value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="show_home_page">Show Home Page</label>
                                    <select name="show_homepage" id="show_home_page" class="form-control">
                                        <option {{ $department->show_homepage ==0 ? 'selected' :'' }} value="0">No</option>
                                        <option {{ $department->show_homepage ==1 ? 'selected' :'' }} value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <button type="submit" class="btn btn-success">Save Department</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
