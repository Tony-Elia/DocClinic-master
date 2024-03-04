@extends('layouts.admin.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','habit')->first()->custom_lang }}</title>
@endsection
@section('admin-content')
<style>
    .btn-row button{
        margin-top: 30px;
    }
</style>
    <!-- Page Heading -->

    <h1 class="h3 mb-2 text-gray-800"><a href="#" data-toggle="modal" data-target="#addHabit" class="btn btn-success"><i class="fas fa-plus" aria-hidden="true"></i>{{ $websiteLang->where('lang_key','create')->first()->custom_lang }} </a></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','habit_table')->first()->custom_lang }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                            <th width="25%">{{ $websiteLang->where('lang_key','habit')->first()->custom_lang }}</th>
                            <th width="15%">{{ $websiteLang->where('lang_key','action')->first()->custom_lang }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($habits as $index => $item)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $item->habit }}</td>
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
    <div class="modal fade" id="addHabit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">{{ $websiteLang->where('lang_key','habit_form')->first()->custom_lang }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">

                    <form action="{{ route('admin.habit.store') }}" method="POST">
                        @csrf
                        <div id="inputRow">
                            <div class="row" >
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="habit">{{ $websiteLang->where('lang_key','habit')->first()->custom_lang }}</label>
                                        <input type="text" name="habit[]" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3 btn-row">
                                    <button type="button" class="btn btn-success" id="addHabitRow">+</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $websiteLang->where('lang_key','close')->first()->custom_lang }}</button>
                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','save')->first()->custom_lang }}</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- update video Modal -->
@foreach ($habits as $habit)
    <div class="modal fade" id="updateVideo-{{ $habit->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">{{ $websiteLang->where('lang_key','habit_form')->first()->custom_lang }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="container-fluid">

                    <form action="{{ route('admin.habit.update',$habit->id) }}" method="POST">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="habit">{{ $websiteLang->where('lang_key','habit')->first()->custom_lang }}</label>
                            <input type="text" name="habit" class="form-control" value="{{ $habit->habit }}">
                        </div>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $websiteLang->where('lang_key','close')->first()->custom_lang }}</button>
                        <button type="submit" class="btn btn-success">{{ $websiteLang->where('lang_key','update')->first()->custom_lang }}</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endforeach


    <script>
        function deleteData(id){
            $("#deleteForm").attr("action",'{{ url("admin/habit/") }}'+"/"+id)
        }
    </script>

@endsection
