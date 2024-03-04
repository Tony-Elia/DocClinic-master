@extends('layouts.patient.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','order_list')->first()->custom_lang }}</title>
@endsection
@section('patient-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->profile ? url($banner->profile) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $websiteLang->where('lang_key','order_list')->first()->custom_lang }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $websiteLang->where('lang_key','order_list')->first()->custom_lang }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Dashboard Start-->
<div class="dashboard-area pt_70 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('patient.profile.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="detail-dashboard">
                <h2 class="d-headline">{{ $websiteLang->where('lang_key','order_list')->first()->custom_lang }}</h2>
                <div class="table-responsive">
                <table class="coustom-dashboard dashboard-table display" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th width="5%">{{ $websiteLang->where('lang_key','order_id')->first()->custom_lang }}</th>
                            <th width="5%">{{ $websiteLang->where('lang_key','fee')->first()->custom_lang }}</th>
                            <th width="5%">{{ $websiteLang->where('lang_key','total_app')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','date')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','payment')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','action')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $item->order_id }}</td>
                            <td>{{ $currency->currency_icon }}{{ $item->total_payment }}</td>
                            <td>{{ $item->appointment_qty }}</td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($item->payment_status==0)
                                        <span class="badge badge-danger">{{ $websiteLang->where('lang_key','pending')->first()->custom_lang }}</span>
                                    @else
                                    <span class="badge badge-success">{{ $websiteLang->where('lang_key','success')->first()->custom_lang }}</span>
                                    @endif
                            </td>
                            <td>
                                <a  data-toggle="modal" data-target="#orderDetails-{{ $item->id }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    </table>
                    {{ $orders->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Dashboard End-->

@foreach ($orders as $item)
<!-- Modal -->
<div class="modal fade" id="orderDetails-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <h4>{{ $websiteLang->where('lang_key','order_info')->first()->custom_lang }}:</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','fee')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','payment_method')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','tran_id')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','payment')->first()->custom_lang }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $item->order_id }}</td>
                                <td>{{ $currency->currency_icon }}{{ $item->total_payment }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>{{ $item->payment_transaction_id }}</td>
                                <td>
                                    @if ($item->payment_status==0)
                                            <span class="badge badge-danger">{{ $websiteLang->where('lang_key','pending')->first()->custom_lang }}</span>
                                        @else
                                        <span class="badge badge-success">{{ $websiteLang->where('lang_key','success')->first()->custom_lang }}</span>
                                        @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h4 class="mt-4">{{ $websiteLang->where('lang_key','app_history')->first()->custom_lang }}:</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','schedule')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','date')->first()->custom_lang }}</th>
                                <th>{{ $websiteLang->where('lang_key','fee')->first()->custom_lang }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item->appointments as $index => $item)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ ucfirst($item->doctor->name) }}</td>
                                <td>{{ $item->doctor->phone }}</td>
                                <td>{{ strtoupper($item->schedule->start_time).'-'.strtoupper($item->schedule->end_time) }}</td>
                                <td>{{ $item->date }}</td>
                                <td>
                                    ${{ $item->appointment_fee }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-dismiss="modal">{{ $websiteLang->where('lang_key','close')->first()->custom_lang }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection
