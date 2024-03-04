@extends('layouts.admin.layout')
@section('title')
<title>{{ $patient->name }}</title>
@endsection
@section('admin-content')
    <h1><a href="{{ route('admin.patients') }}" class="btn btn-success"><i class="fas fa-list"></i> {{ $websiteLang->where('lang_key','all_patient')->first()->custom_lang }}</a></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body" id="search-appointment">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','photo')->first()->custom_lang }}</td>
                            <td>
                                @if ($patient->image)
                                <img class="img-thumbnail" src="{{ url($patient->image) }}" alt="Patient Image" width="100px">
                                @else
                                <img class="img-thumbnail" src="{{ $user_image->default_profile ? url($user_image->default_profile) :'' }}" alt="Patient Image" width="100px">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</td>
                            <td>{{ $patient->name }}</td>
                        </tr>

                        <tr>
                            <td>{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</td>
                            <td>{{ $patient->email }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','app')->first()->custom_lang }}</td>
                            <td>{{ $patient->appointment->count() }}</td>
                        </tr>

                        <tr>
                            <td>{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }}</td>
                            <td>{{ $patient->Phone }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','guardian_name')->first()->custom_lang }}</td>
                            <td>{{ $patient->guardian_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','guardian_phone')->first()->custom_lang }}</td>
                            <td>{{ $patient->guardian_phone }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','occupation')->first()->custom_lang }}</td>
                            <td>{{ $patient->occupation }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','age')->first()->custom_lang }}</td>
                            <td>{{ $patient->age }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','dob')->first()->custom_lang }}</td>
                            <td>{{ $patient->date_of_birth }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','gender')->first()->custom_lang }}</td>
                            <td>{{ $patient->gender }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','weight')->first()->custom_lang }}</td>
                            <td>{{ $patient->weight }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','height')->first()->custom_lang }}</td>
                            <td>{{ $patient->height }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','disability')->first()->custom_lang }}</td>
                            <td>{{ $patient->disablities }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','helth_ins_num')->first()->custom_lang }}</td>
                            <td>{{ $patient->helth_insurance_number }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','helth_card_num')->first()->custom_lang }}</td>
                            <td>{{ $patient->helth_card_number }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','helth_card_pro')->first()->custom_lang }}</td>
                            <td>{{ $patient->health_card_provider }}</td>
                        </tr>




                    </thead>

                </table>
            </div>
        </div>
    </div>
@endsection

