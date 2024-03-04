@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','dep_img')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
<style>
    .btn-row button{
        margin-top: 30px;
    }
</style>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.department.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','all_dep')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','dep_img')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','exist_img')->first()->custom_lang }} : </label>
                                    <div>
                                        <img src="{{ url($department->thumbnail_image) }}" alt="Thumbnail Image" width="120px">
                                    </div>
                                </div>
                            <form action="{{ route('admin.department.thumbnail.image',$department->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','thumb_img')->first()->custom_lang }}</label>
                                    <input type="file" name="thumbnail_image" class="form-control">
                                    <input type="hidden" name="old_thumbnail" value="{{ $department->thumbnail_image }}">
                                </div>

                                <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','save')->first()->custom_lang }}</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            @if (count($images)>0)
                                <h4>{{ $websiteLang->where('lang_key','slider_img')->first()->custom_lang }}</h4>
                                    <table class="table table-bordered mb-5">
                                        @foreach ($images as $item)
                                            <tr>
                                                @if ($item->small_image)
                                                <td><img src="{{ url($item->small_image) }}" alt="Service Image" width="120px"></td>
                                                @else
                                                <td><img src="" alt="Service Image" width="120px"></td>
                                                @endif
                                                <td><a href="{{ route('admin.delete.department.image',$item->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                                            </tr>
                                        @endforeach
                                    </table>
                            @else
                                <h4 class="text-danger">{{ $websiteLang->where('lang_key','img_not_found')->first()->custom_lang }}</h4>
                            @endif

                    <div class="my-5"></div>

                    <form action="{{ route('admin.department.image.store',$department->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="addRow">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">{{ $websiteLang->where('lang_key','img')->first()->custom_lang }}</label>
                                        <input type="file" name="image[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 btn-row">
                                    <button type="button" id="addImageRow" class="btn btn-success" ><i class="fas fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','save')->first()->custom_lang }}</button>
                    </form>

                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

@endsection
