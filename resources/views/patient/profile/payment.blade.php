@extends('layouts.patient.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','payment')->first()->custom_lang }}</title>
@endsection
@section('patient-content')


<!--Banner Start-->
<div class="banner-area flex" style="background-image:url({{ $banner->payment ?  url($banner->payment) : '' }});">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>{{ $navigation->payment }}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ $navigation->home }}</a></li>
                        <li><span>{{ $navigation->payment }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Banner End-->

<!--Check Out Start-->
<div class="check-out pt_40 pb_70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="checkout-table table-responsive">

                    <h4>{{ $websiteLang->where('lang_key','app_list')->first()->custom_lang }}</h4>

                    <table class="table">
                        <thead>
                            <tr>
                                <th><b>{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</b></th>
                                <th><b>{{ $websiteLang->where('lang_key','dep')->first()->custom_lang }}</b></th>
                                <th><b>{{ $websiteLang->where('lang_key','location')->first()->custom_lang }}</b></th>
                                <th><b>{{ $websiteLang->where('lang_key','date')->first()->custom_lang }}</b></th>
                                <th><b>{{ $websiteLang->where('lang_key','schedule')->first()->custom_lang }}</b></th>
                                <th><b>{{ $websiteLang->where('lang_key','fee')->first()->custom_lang }} ({{ $currency->currency_name }})</b></th>
                                <th><b>{{ $websiteLang->where('lang_key','action')->first()->custom_lang }}</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $i => $item)
                            <tr>
                                <td>{{ ucfirst($item->name) }}</td>
                                <td>{{ $item->options->department }}</td>
                                <td>{{ $item->options->location }}</td>
                                <td>{{ $item->options->date }}</td>
                                <td>{{ strtoupper($item->options->time) }}</td>
                                <td>{{ $currency->currency_icon }}{{ $item->price }}</td>
                                <td><a href="{{ url('remove-appointment/'.$item->rowId) }}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a></td>
                            </tr>
                            @endforeach


                            <tr>
                                <td class="text-right" colspan="5"><b>{{ $websiteLang->where('lang_key','total')->first()->custom_lang }}</b></td>
                                <td class="" colspan="2"><b>{{ $currency->currency_icon }}{{ Cart::pricetotal() }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($appointments->count() !=0)
        <div class="row">
            <div class="col-12">
                <div class="payment-select">
                    <h4>{{ $websiteLang->where('lang_key','pay_now')->first()->custom_lang }}</h4>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">

                        @if ($paymentSetting->stripe_status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="stripe-tab" data-toggle="tab" href="#stripe" role="tab" aria-controls="stripe" aria-selected="true">{{ $websiteLang->where('lang_key','stripe')->first()->custom_lang }}</a>
                            </li>
                        @endif

                        @if ($paymentSetting->paypal_status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">{{ $websiteLang->where('lang_key','paypal')->first()->custom_lang }}</a>
                            </li>
                        @endif

                        @if ($razorpay->razorpay_status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="razorpay-tab" data-toggle="tab" href="#razorpay" role="tab" aria-controls="paypal" aria-selected="false">{{ $websiteLang->where('lang_key','razorpay')->first()->custom_lang }}</a>
                            </li>
                        @endif

                        @if ($flutterwave->status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="flutterwave-tab" data-toggle="tab" href="#flutterwave" role="tab" aria-controls="paypal" aria-selected="false">{{ $websiteLang->where('lang_key','flutterwave')->first()->custom_lang }}</a>
                            </li>
                        @endif

                        @if ($paystack->paystack_status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="paystack-tab" data-toggle="tab" href="#paystack" role="tab" aria-controls="paypal" aria-selected="false">{{ $websiteLang->where('lang_key','paystack')->first()->custom_lang }}</a>
                            </li>
                        @endif

                        @if ($mollie->mollie_status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="mollie-tab" data-toggle="tab" href="#mollie" role="tab" aria-controls="paypal" aria-selected="false">{{ $websiteLang->where('lang_key','mollie')->first()->custom_lang }}</a>
                            </li>
                        @endif

                        @if ($instamojo->status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="instamojo-tab" data-toggle="tab" href="#instamojo" role="tab" aria-controls="paypal" aria-selected="false">{{ $websiteLang->where('lang_key','instamojo')->first()->custom_lang }}</a>
                            </li>
                        @endif

                        @if ($paymongo->status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="paymongo-tab" data-toggle="tab" href="#paymongo" role="tab" aria-controls="paypal" aria-selected="false">{{ $websiteLang->where('lang_key','paymongo')->first()->custom_lang }}</a>
                            </li>
                        @endif



                        @if ($paymentSetting->bank_status)
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="false">{{ $websiteLang->where('lang_key','ban_trans')->first()->custom_lang }}</a>
                            </li>
                        @endif

                      </ul>
                      <div class="tab-content" id="myTabContent">
                        @if ($paymentSetting->stripe_status)
                        <div class="tab-pane fade show active mt-5" id="stripe" role="tabpanel" aria-labelledby="stripe-tab">
                            <div class="payment-select-group">
                                @if (Session::has('success'))
                                    <div class="alert alert-success text-center">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                        <p>{{ Session::get('success') }}</p>
                                    </div>
                                @endif
                                <form role="form" action="{{ route('patient.stripe.payment') }}" method="post" class="require-validation"
                                data-cc-on-file="false"
                                data-stripe-publishable-key="{{ $stripe->stripe_key }}"
                                id="payment-form">
                                @csrf

                                <div class='form-row row mt_30'>
                                    <div class='col-sm-6 col-12 form-group required'>
                                        <label class='control-label'>{{ $websiteLang->where('lang_key','card_num')->first()->custom_lang }}</label> <input
                                            autocomplete='off' class='form-control card-number' size='20'
                                            type='text' name="card_digit">
                                    </div>


                                    <div class='col-sm-6 col-12 form-group cvc required'>
                                        <label class='control-label'>{{ $websiteLang->where('lang_key','cvc')->first()->custom_lang }}</label> <input autocomplete='off'
                                            class='form-control card-cvc' size='4'
                                            type='text'>
                                    </div>

                                    <div class='col-sm-6 col-12 form-group expiration required'>
                                        <label class='control-label'>{{ $websiteLang->where('lang_key','exp_month')->first()->custom_lang }}</label> <input
                                            class='form-control card-expiry-month' size='2'
                                            type='text'>
                                    </div>

                                    <div class='col-sm-6 col-12 form-group expiration required'>
                                        <label class='control-label'>{{ $websiteLang->where('lang_key','exp_year')->first()->custom_lang }}</label> <input
                                            class='form-control card-expiry-year'  size='4'
                                            type='text'>
                                    </div>
                                </div>
                                <div class='form-row row'>
                                    <div class='col-md-12 error form-group hide d-none'>
                                        <div class='alert-danger alert'>{{ $websiteLang->where('lang_key','card_error')->first()->custom_lang }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="payment-order-button col-3">
                                    <button type="submit">{{ $websiteLang->where('lang_key','payment')->first()->custom_lang }}</button>
                                </div>
                            </div>
                        </form>
                        </div>
                        @endif

                        @if ($paymentSetting->paypal_status)
                            <div class="tab-pane fade mt-5" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
                                <form action="{{ url('patient/store-paypal') }}" method="POST">
                                    @csrf
                                <div class="row">

                                    <div class="payment-order-button col-3">
                                        <button type="submit">{{ $websiteLang->where('lang_key','pay_paypal')->first()->custom_lang }}</button>
                                    </div>

                                </div>
                            </form>
                            </div>
                        @endif


                        @if ($razorpay->razorpay_status)
                            <div class="tab-pane fade mt-5" id="razorpay" role="tabpanel" aria-labelledby="razorpay-tab">
                                <form action="{{ route('patient.razorpay-payment') }}" method="POST" >
                                    @csrf

                                    @php
                                        $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
                                        $payableAmount = round($cartPrice * $razorpay->currency_rate,2);
                                    @endphp

                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ $razorpay->razorpay_key }}"
                                            data-amount= "{{ $payableAmount * 100 }}"
                                            data-buttontext="{{ $websiteLang->where('lang_key','pay')->first()->custom_lang }} {{ $payableAmount }} {{ $razorpay->currency_code }}"
                                            data-name="{{ $razorpay->name }}"
                                            data-description="{{ $razorpay->description }}"
                                            data-image="{{ asset($razorpay->image) }}"
                                            data-prefill.name=""
                                            data-prefill.email=""
                                            data-theme.color="{{ $razorpay->theme_color }}">
                                    </script>
                                </form>
                            </div>
                        @endif

                        @php
                            $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
                            $usd_amount= round($cartPrice / $setting->currency_rate,2);
                            $tnx_ref = substr(rand(0,time()),0,7);
                        @endphp

                        @if ($flutterwave->status)
                            <div class="tab-pane fade mt-5" id="flutterwave" role="tabpanel" aria-labelledby="flutterwave-tab">
                                <div class="row">
                                    <div class="payment-order-button col-6">
                                        <button type="button" onclick="makePayment()">{{ $websiteLang->where('lang_key','pay_with_flutterwave')->first()->custom_lang }}</button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="tab-pane fade mt-5" id="paystack" role="tabpanel" aria-labelledby="paystack-tab">
                            <div class="row">
                                <div class="payment-order-button col-6">
                                    <button type="button" onclick="payWithPaystack()">{{ $websiteLang->where('lang_key','pay_with_paystack')->first()->custom_lang }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade mt-5" id="mollie" role="tabpanel" aria-labelledby="mollie-tab">
                            <div class="row">
                                <div class="payment-order-button col-3">
                                    <a href="{{ route('patient.mollie-payment') }}">{{ $websiteLang->where('lang_key','pay_with_mollie')->first()->custom_lang }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade mt-5" id="instamojo" role="tabpanel" aria-labelledby="instamojo-tab">
                            <div class="row">
                                <div class="payment-order-button col-3">
                                    <a href="{{ route('patient.pay-with-instamojo') }}">{{ $websiteLang->where('lang_key','pay_with_instamojo')->first()->custom_lang }}</a>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade mt-5" id="paymongo" role="tabpanel" aria-labelledby="paymongo-tab">
                            <div class="row">
                                <div class="payment-order-button">
                                    <a href="javascript:;" data-toggle="modal" data-target="#paymongo_modal">{{ $websiteLang->where('lang_key','card_payment')->first()->custom_lang }}</a>

                                    <a href="{{ route('patient.pay-with-grab-pay') }}">{{ $websiteLang->where('lang_key','grab_pay')->first()->custom_lang }}</a>

                                    <a href="{{ route('patient.pay-with-gcash') }}">{{ $websiteLang->where('lang_key','gcash')->first()->custom_lang }}</a>
                                </div>
                            </div>
                        </div>


                        @if ($paymentSetting->bank_status)
                            <div class="tab-pane fade mt-5" id="bank" role="tabpanel" aria-labelledby="bank-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="{{ route('patient.bank.payment') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="description">{{ $websiteLang->where('lang_key','tran_info')->first()->custom_lang }}</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" required></textarea>
                                            </div>

                                            <div class="payment-order-button">
                                                <button type="submit">{{ $websiteLang->where('lang_key','payment')->first()->custom_lang }}</button>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bank contact-info-item bg2 mb_30 mt_30">
                                            <div class="contact-info">
                                                <span>
                                                    {{ $websiteLang->where('lang_key','account_info')->first()->custom_lang }}:
                                                </span>
                                                <div class="contact-text">
                                                    <p class="card-text">
                                                        {!! clean(nl2br(e($stripe->bank_account))) !!}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        @endif


                      </div>

                </div>

            </div>
        </div>
        @endif
    </div>
</div>
<!--Check Out End-->



<!-- Modal -->
<div class="modal fade" id="paymongo_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $websiteLang->where('lang_key','create_app')->first()->custom_lang }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body book-appointment">
                <form role="form" action="{{ route('patient.pay-with-paymongo') }}" method="post" >
                @csrf
                    <div>
                        <div class='form-row row'>
                            <div class='col-sm-6 col-12 form-group'>
                                <label class='control-label'>{{ $websiteLang->where('lang_key','card_num')->first()->custom_lang }}</label> <input
                                    autocomplete='off' class='form-control' size='20'
                                    type='text' name="card_number" required>
                            </div>

                            <div class='col-sm-6 col-12 form-group cvc'>
                                <label class='control-label'>{{ $websiteLang->where('lang_key','cvc')->first()->custom_lang }}</label> <input autocomplete='off'
                                    class='form-control' size='4'
                                    type='text' required name="cvc">
                            </div>

                            <div class='col-sm-6 col-12 form-group expiration'>
                                <label class='control-label'>{{ $websiteLang->where('lang_key','exp_month')->first()->custom_lang }}</label> <input
                                    class='form-control' size='2'
                                    type='text' required name="month">
                            </div>

                            <div class='col-sm-6 col-12 form-group expiration'>
                                <label class='control-label'>{{ $websiteLang->where('lang_key','exp_year')->first()->custom_lang }}</label> <input
                                    class='form-control'  size='4'
                                    type='text' required name="year">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="payment-order-button ml-3">
                            <button type="submit">{{ $websiteLang->where('lang_key','payment')->first()->custom_lang }}</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- // Modal -->


<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>

@if ($appointments->count() !=0)

@php
    $cartPrice = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), '', Cart::pricetotal());
    // start paystack
    $public_key = $paystack->paystack_public_key;
    $currency = $paystack->paystack_currency_code;
    $currency = strtoupper($currency);


    $ngn_amount = $cartPrice * $paystack->paystack_currency_rate;
    $ngn_amount = $ngn_amount * 100;
    $ngn_amount = round($ngn_amount);
    // end paystack

    // start flutterwave
    $payable_amount = $cartPrice * $flutterwave->currency_rate;
    $payable_amount = round($payable_amount, 2);
    // end flutterwave
@endphp

<script>
    function makePayment() {
      FlutterwaveCheckout({
        public_key: "{{ $flutterwave->public_key }}",
        tx_ref: "RX1_{{ $tnx_ref }}",
        amount: {{ $payable_amount }},
        currency: "{{ $flutterwave->currency_code }}",
        country: "{{ $flutterwave->country_code }}",
        payment_options: " ",
        customer: {
          email: "{{ $user->email }}",
          phone_number: "{{ $user->phone }}",
          name: "{{ $user->name }}",
        },
        callback: function (data) {
            var tnx_id = data.transaction_id;
            var _token = "{{ csrf_token() }}";
            $.ajax({
                type: 'post',
                data : {tnx_id,_token},
                url: "{{ url('patient/flutterwave-payment/') }}",
                success: function (response) {
                    if(response.status == 'success'){
                        toastr.success(response.message);
                        window.location.href = "{{ route('patient.order') }}";
                    }else{
                        toastr.error(response.message);
                        window.location.reload();

                    }
                },
                error: function(err) {}
            });

        },
        customizations: {
          title: "{{ $flutterwave->title }}",
          logo: "{{ asset($flutterwave->logo) }}",
        },
      });
    }


    function payWithPaystack(){
        var handler = PaystackPop.setup({
            key: '{{ $public_key }}',
            email: '{{ $user->email }}',
            amount: '{{ $ngn_amount }}',
            currency: "{{ $currency }}",
            callback: function(response){
            let reference = response.reference;
            let tnx_id = response.transaction;
            let _token = "{{ csrf_token() }}";
            $.ajax({
                type: "post",
                data: {reference, tnx_id, _token},
                url: "{{ route('patient.paystack-payment') }}",
                success: function(response) {
                    if(response.status == 'success'){
                        window.location.href = "{{ route('patient.order') }}";
                    }else{
                        window.location.reload();
                    }
                }
            });
            },
            onClose: function(){
                alert('window closed');
            }
        });
        handler.openIframe();
    }

</script>
@endif

@endsection
