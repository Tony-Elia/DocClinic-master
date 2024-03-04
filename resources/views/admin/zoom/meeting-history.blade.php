@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','zoom_meeting')->first()->custom_lang }}</title>
@endsection
@section('admin-content')

    <div class="card shadow mb-4">
        <div class="card-body">
            <h4 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','upcoming_meeting')->first()->custom_lang }}</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered" id="example-1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th >{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','patient')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','time')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','duration')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($histories as $index => $meeting)
                        @php
                            $now=date('Y-m-d h:i:A');
                        @endphp

                        @if ($now < date('Y-m-d h:i:A',strtotime($meeting->meeting_time)))
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $meeting->doctor->name }}</td>
                            <td>{{ $meeting->user->name }}</td>
                            <td>
                                {{ date('Y-m-d h:i:A',strtotime($meeting->meeting_time)) }}
                            </td>
                            <td>{{ $meeting->duration }} {{ $websiteLang->where('lang_key','minutes')->first()->custom_lang }}</td>
                        </tr>
                        @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <h4 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','previous_meeting')->first()->custom_lang }}</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th >{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','patient')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','time')->first()->custom_lang }}</th>
                            <th >{{ $websiteLang->where('lang_key','duration')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($histories as $index => $meeting)
                        @php
                            $now=date('Y-m-d h:i:A');
                        @endphp

                        @if ($now > date('Y-m-d h:i:A',strtotime($meeting->meeting_time)))
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $meeting->doctor->name }}</td>
                            <td>{{ $meeting->user->name }}</td>
                            <td>
                                {{ date('Y-m-d h:i:A',strtotime($meeting->meeting_time)) }}
                            </td>
                            <td>{{ $meeting->duration }} {{ $websiteLang->where('lang_key','minute')->first()->custom_lang }}</td>
                        </tr>
                        @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
