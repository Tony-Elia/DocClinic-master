@extends('layouts.doctor.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','app_history')->first()->custom_lang }}</title>
@endsection
@section('doctor-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','app_history')->first()->custom_lang }}</h6>
        </div>
        <div class="card-body" id="search-appointment">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','dep')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','date')->first()->custom_lang }}</th>
                            <th width="10%">{{ $websiteLang->where('lang_key','action')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ ucfirst($item->user->name) }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>{{ ucwords($item->doctor->name) }}</td>
                            <td>{{ ucwords($item->doctor->department->name) }}</td>
                            <td>{{ date('m-d-Y',strtotime($item->date)) }}</td>

                            <td>
                                <a target="_blank" href="{{ route('doctor.treatment',$item->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
