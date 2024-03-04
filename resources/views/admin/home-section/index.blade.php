@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','home_section')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','home_section')->first()->custom_lang }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th width="20%">{{ $websiteLang->where('lang_key','section_name')->first()->custom_lang }}</th>
                            <th width="20%">{{ $websiteLang->where('lang_key','first_header')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','second_header')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','content_qty')->first()->custom_lang }}</th>
                            <th width="10%">{{ $websiteLang->where('lang_key','show_homepage')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','action')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ ucwords($item->section_name) }}</td>
                            <td>{{ ucwords($item->first_header) }}</td>
                            <td>{{ ucwords($item->second_header) }}</td>
                            <td>{{ $item->content_quantity }}</td>
                            <td>
                                @if ($item->show_homepage==1)
                                <a href="" onclick="homseSectionStatus({{ $item->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}" data-off="{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}" data-onstyle="success" data-offstyle="danger"></a>
                                @else
                                    <a href="" onclick="homseSectionStatus({{ $item->id }})"><input type="checkbox" data-toggle="toggle" data-on="{{ $websiteLang->where('lang_key','active')->first()->custom_lang }}" data-off="{{ $websiteLang->where('lang_key','inactive')->first()->custom_lang }}" data-onstyle="success" data-offstyle="danger"></a>

                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.home-section.edit',$item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
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
            $("#deleteForm").attr("action",'{{ url("admin/home-section/") }}'+"/"+id)
        }

        function homseSectionStatus(id){
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
                url:"{{url('/admin/home-section-status/')}}"+"/"+id,
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
