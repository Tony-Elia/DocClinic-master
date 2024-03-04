@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','doctor')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('admin.doctor.create') }}" class="btn btn-primary"><i class="fas fa-plus" aria-hidden="true"></i> {{ $websiteLang->where('lang_key','create')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','doc_table')->first()->custom_lang }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th width="10%">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</th>
                            <th width="10%">{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</th>
                            <th width="10%">{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }}</th>
                            <th width="5%">{{ $websiteLang->where('lang_key','fee')->first()->custom_lang }}</th>
                            <th width="5%">{{ $websiteLang->where('lang_key','img')->first()->custom_lang }}</th>
                            <th width="5%">{{ $websiteLang->where('lang_key','status')->first()->custom_lang }}</th>
                            <th width="25%">{{ $websiteLang->where('lang_key','action')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $currency->currency_icon }}{{ $item->fee }}</td>
                            <td><img src="{{ url($item->image) }}" alt="doctor image" width="80px"></td>
                            <td>
                                @if ($item->status==1)
                                <a href="" onclick="doctorStatus({{ $item->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}" data-off="{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}" data-onstyle="success" data-offstyle="danger"></a>
                                @else
                                    <a href="" onclick="doctorStatus({{ $item->id }})"><input type="checkbox" data-toggle="toggle" data-on="{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}" data-off="{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}" data-onstyle="success" data-offstyle="danger"></a>

                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.doctor.edit',$item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit    "></i></a>
                                <a target="_blank" href="{{ url('doctor-details/'.$item->slug) }}" class="btn btn-success btn-sm"><i class="fas fa-eye    "></i></a>
                                @php
                                    $schedule_count=$schedules->where('doctor_id',$item->id)->count();
                                    $message_count_one=$messages->where('to',$item->id)->count();
                                    $message_count_two=$messages->where('from',$item->id)->count();
                                    $appointment_count=$appointments->where('doctor_id',$item->id)->count();



                                @endphp
                                @if ($schedule_count==0 && $message_count_one==0 && $message_count_two==0 && $appointment_count==0)
                                <a data-toggle="modal" data-target="#deleteModal" href="javascript:;" onclick="deleteData({{ $item->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash    "></i></a>
                                @endif



                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("admin/doctor/") }}'+"/"+id)
        }

        function doctorStatus(id){
                  // project demo mode check
         var isDemo="{{ env('PROJECT_MODE') }}"
         var demoNotify="{{ env('NOTIFY_TEXT') }}"
         if(isDemo==0){
             toastr.error(demoNotify);
             return;
         }
         // end
            $.ajax({
                type:"get",
                url:"{{url('/admin/doctor-status/')}}"+"/"+id,
                success:function(response){
                   toastr.success(response)
                },
                error:function(err){
                    console.log(err);

                }
            })
        }
    </script>
@endsection
