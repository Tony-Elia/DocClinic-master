@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','prescription')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- DataTales Example -->
    <div class="row mb-2" id="searchSchedule">
        <div class="col-md-3">
            <div class="form-group">
                <label for="">{{ $websiteLang->where('lang_key','from')->first()->custom_lang }}</label>
                <input type="text" class="form-control datepicker" id="from_date">
                <p class="invalid-feedback d-none" id="from_date_error"></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="">{{ $websiteLang->where('lang_key','to')->first()->custom_lang }}</label>
                <input type="text" id="to_date" class="form-control datepicker">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="">{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</label>
                <select name="doctor_id" id="doctor_id" class="form-control select2">
                    <option value="">{{ $websiteLang->where('lang_key','select_doc')->first()->custom_lang }}</option>
                    @foreach ($doctors as $item)
                    <option value="{{ $item->id }}">{{ ucwords($item->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3 newsearch">
            <button type="button" id="searchPrescribe" class="btn btn-success">{{ $websiteLang->where('lang_key','search')->first()->custom_lang }}</button>
        </div>
    </div>
    <div id="prescribe-box">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','prescription_history')->first()->custom_lang }} <button class="btn btn-success btn-sm print_btn" onclick="printReport()"><i class="fas fa-print    "></i></button></h6>
        </div>
        <div class="card-body" id="search-appointment">
            <div class="table-responsive printArea">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','date')->first()->custom_lang }}</th>
                            <th width="25%">{{ $websiteLang->where('lang_key','schedule')->first()->custom_lang }}</th>
                            <th width="10%">{{ $websiteLang->where('lang_key','action')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ ucfirst($item->user->name) }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>{{ $item->doctor->name }}</td>
                            <td>{{ date('m-d-Y',strtotime($item->date)) }}</td>
                            <td>{{ strtoupper($item->schedule->start_time).'-'.strtoupper($item->schedule->end_time) }}</td>

                            <td>
                                <a  href="{{ route('admin.prescribe.show',$item->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


    <script>
	(function($) {

    "use strict";
        // remove prescribe medicine input field row
        $(document).on('click', '#searchPrescribe', function () {
           var from_date=$("#from_date").val();
           var doctor_id=$("#doctor_id").val();
           if(from_date){
               $('#from_date').removeClass('is-invalid')
               $('#from_date_error').addClass('d-none')
               var to_date=$("#to_date").val();
               if(to_date) to_date=to_date;
               else to_date=from_date;
               $.ajax({
                   type: 'GET',
                   url: "{{ route('admin.prescribe.search') }}",
                   data:{from_date,to_date,doctor_id},
                   success: function (response) {
                       $('#prescribe-box').html(response)
                   },
                   error: function(err) {
                       console.log(err);
                   }
               });

           }else{
               toastr.error('{{ $validation }}')
               $('#from_date').addClass('is-invalid')
               $('#from_date_error').text('{{ $validation }}')
               $('#from_date_error').removeClass('d-none')
           }


       });
	   })(jQuery);

   </script>
@endsection

