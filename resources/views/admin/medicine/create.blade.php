@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','medicine')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
<style>
    .btn-row button{
        margin-top: 30px;
    }
</style>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.medicine.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','all_medicine')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','medicine_form')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.medicine.store') }}" method="POST">
                        @csrf
                        <div id="medicine-row">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="name">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</label>
                                        <input type="text" class="form-control" name="name[]" id="name">
                                    </div>
                                </div>
                                <div class="col-md-3 btn-row">
                                    <button type="button" class="btn btn-success" id="addMedicineRow"><i class="fas fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>



                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','save')->first()->custom_lang }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
