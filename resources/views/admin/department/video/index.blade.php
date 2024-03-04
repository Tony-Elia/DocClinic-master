@extends('layouts.admin.layout')
@section('title','Department video')
@section('admin-content')
<style>
    .btn-row button{
        margin-top: 30px;
    }
</style>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 d-inline"><a href="{{ route('admin.department.index') }}" class="btn btn-primary"><i class="fas fa-list" aria-hidden="true"></i> All Departments </a></h1>
    <h1 class="h3 mb-2 text-gray-800 d-inline"><a href="#" data-toggle="modal" data-target="#addVidoe" class="btn btn-success"><i class="fas fa-plus" aria-hidden="true"></i> New Video </a></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Video Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">SN</th>
                            <th width="25%">Department</th>
                            <th width="25%">Link</th>
                            <th width="10%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videos as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $item->department->name }}</td>
                            <td><a target="_blank" href="{{ $item->link }}">{{ $item->link }}</a></td>
                            <td>
                                @if ($item->status==1)
                                    <a href="" onclick="departmentVideoStatus({{ $item->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="In-Active" data-onstyle="success" data-offstyle="danger"></a>
                                @else
                                    <a href="" onclick="departmentVideoStatus({{ $item->id }})"><input type="checkbox" data-toggle="toggle" data-on="Active" data-off="In-Active" data-onstyle="success" data-offstyle="danger"></a>

                                @endif

                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#updateVideo-{{ $item->id }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                <a data-toggle="modal" data-target="#deleteModal" href="javascript:;" onclick="deleteData({{ $item->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash    "></i></a>


                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- create video Modal -->
    <div class="modal fade" id="addVidoe" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Department Video Form</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">

                    <form action="{{ route('admin.department-video.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <select name="name" id="name" class="form-control">
                                <option value="">Select Departement</option>
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="inputRow">
                            <div class="row" >
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="text" name="link[]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3 btn-row">
                                    <button type="button" class="btn btn-success" id="addRow">+</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- update video Modal -->
@foreach ($videos as $video)
    <div class="modal fade" id="updateVideo-{{ $video->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">Department Video Form</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">

                    <form action="{{ route('admin.department-video.update',$video->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <select name="name" id="name" class="form-control">
                                <option value="">Select Departement</option>
                                @foreach ($departments as $item)
                                    <option {{ $item->id==$video->department_id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="link">Link</label>
                            <input type="text" name="link" class="form-control" value="{{ $video->link }}">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option {{ $video->status==1 ? 'selected':'' }} value="1">Active</option>
                                <option {{ $video->status==0 ? 'selected':'' }} value="0">In-Active</option>
                            </select>
                        </div>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endforeach


    <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("admin/department-video/") }}'+"/"+id)
        }



        function departmentVideoStatus(id){

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
                url:"{{url('/admin/department-video-status/')}}"+"/"+id,
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
