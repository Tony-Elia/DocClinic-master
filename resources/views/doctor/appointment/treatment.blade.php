@extends('layouts.doctor.layout')
@section('title')
<title>{{ $websiteLang->where('lang_key','treatment')->first()->custom_lang }}</title>
@endsection
@section('doctor-content')
<style>
    .btn-row button{
        margin-top: 30px;
    }

</style>
    <!-- Appointment Details -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','patient_info')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</td>
                            <td>{{ ucwords($appointment->user->name) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</td>
                            <td>{{ $appointment->user->email }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','age')->first()->custom_lang }}</td>
                            <td>{{ $appointment->user->age }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','gender')->first()->custom_lang }}</td>
                            <td>{{ $appointment->user->gender }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','old_app_history')->first()->custom_lang }}</td>
                            <td><a href="{{ route('doctor.old.appointment',$appointment->user_id) }}">{{ $websiteLang->where('lang_key','history_here')->first()->custom_lang }}</a></td>
                        </tr>

                        @if ($appointment->user->disabilities)
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','disabilities')->first()->custom_lang }}</td>
                            <td>{{ $appointment->user->disabilities }}</td>
                        </tr>
                        @endif


                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','app_info')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','date')->first()->custom_lang }}</td>
                            <td>{{ $appointment->date }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','schedule')->first()->custom_lang }}</td>
                            <td>{{ strtoupper($appointment->schedule->start_time).'-'.strtoupper($appointment->schedule->end_time) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','fee')->first()->custom_lang }}</td>
                            <td>{{ $currency->currency_icon }}{{ $appointment->appointment_fee }}</td>
                        </tr>
                        <tr>
                            <td>{{ $websiteLang->where('lang_key','treated')->first()->custom_lang }}</td>
                            <td>
                                @if ($appointment->already_treated==1)
                                    <span class="badge badge-success">{{ $websiteLang->where('lang_key','yes')->first()->custom_lang }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $websiteLang->where('lang_key','no')->first()->custom_lang }}</span>
                                @endif
                            </td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>

        <form action="{{ route('doctor.treatment.store',$appointment->id) }}" method="POST">
        @csrf
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','physical_info')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','weight')->first()->custom_lang }}</label>
                                    <input type="text" name="weight" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','physical_info')->first()->custom_lang }} </label>
                                    <input type="text" name="blood_pressure" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','pulse_rate')->first()->custom_lang }}</label>
                                    <input type="text" name="pulse_rate" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','temp')->first()->custom_lang }}</label>
                                    <input type="text" name="temperature" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','problem_des')->first()->custom_lang }}</label>
                                    <textarea name="problem_description" id="" cols="30" rows="5" class="form-control"></textarea>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $websiteLang->where('lang_key','select_habit')->first()->custom_lang }}: </label>
                                    <br>
                                    @foreach ($habits as $habit)
                                        <input type="checkbox" name="habit[]" id="habit-{{ $habit->id }}" class="ml-3" value="{{ $habit->id }}"> <label for="habit-{{ $habit->id }}">{{ $habit->habit }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','prescribe')->first()->custom_lang }}</h6>
                </div>
                <div class="card-body" id="medicineRow">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="">{{ $websiteLang->where('lang_key','medicine_type')->first()->custom_lang }}</label>
                            <select name="medicine_type[]" class="form-control" id="">
                                @foreach ($medicineTypes as $type)
                                    <option value="{{ $type->type }}">{{ $type->type }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">{{ $websiteLang->where('lang_key','medicine')->first()->custom_lang }}</label>
                            <select name="medicine_name[]" class="form-control" id="">
                                <option value="">{{ $websiteLang->where('lang_key','select_medicine')->first()->custom_lang }}</option>
                                @foreach ($medicines as $item)
                                    <option value="{{ $item->name }}">{{ ucwords($item->name) }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">{{ $websiteLang->where('lang_key','dosage')->first()->custom_lang }}</label>
                            <select name="dosage[]" id="" class="form-control">
                                <option value="0-0-0">0-0-0</option>
                                <option value="0-0-1">0-0-1</option>
                                <option value="0-1-0">0-1-0</option>
                                <option value="0-1-1">0-1-1</option>
                                <option value="1-0-0">1-0-0</option>
                                <option value="1-0-1">1-0-1</option>
                                <option value="1-1-0">1-1-0</option>
                                <option value="1-1-1">1-1-1</option>

                            </select>
                        </div>
                        <div class="col-md-2" >
                            <label for="">{{ $websiteLang->where('lang_key','days')->first()->custom_lang }}</label>
                            <select name="day[]" id="" class="form-control">
                                @for($i=1;$i<=90;$i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2" >
                            <label for="">{{ $websiteLang->where('lang_key','time')->first()->custom_lang }}</label>
                            <select name="time[]" id="" class="form-control">
                                <option value="After Meal">{{ $websiteLang->where('lang_key','after_meal')->first()->custom_lang }}</option>
                                <option value="Befor Meal">{{ $websiteLang->where('lang_key','before_meal')->first()->custom_lang }}</option>
                            </select>
                        </div>

                        <div class="col-md-1 btn-row">
                            <button id="addMedicineRow" type="button" class="btn btn-primary btn-sm ml-2"><i class="fas fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>

                <div id="hiddenPrescribeRow" class="vh">
                    <div id="delete-prescribe-row">
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <label for="">{{ $websiteLang->where('lang_key','medicine_type')->first()->custom_lang }}</label>
                                <select name="medicine_type[]" class="form-control" id="">
                                    @foreach ($medicineTypes as $type)
                                        <option value="{{ $type->type }}">{{ $type->type }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">{{ $websiteLang->where('lang_key','medicine')->first()->custom_lang }}</label>
                                <select name="medicine_name[]" class="form-control" id="">
                                    <option value="">{{ $websiteLang->where('lang_key','select_medicine')->first()->custom_lang }}</option>
                                    @foreach ($medicines as $item)
                                        <option value="{{ $item->name }}">{{ ucwords($item->name) }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">{{ $websiteLang->where('lang_key','dosage')->first()->custom_lang }}</label>
                                <select name="dosage[]" id="" class="form-control">
                                    <option value="0-0-0">0-0-0</option>
                                    <option value="0-0-1">0-0-1</option>
                                    <option value="0-1-0">0-1-0</option>
                                    <option value="0-1-1">0-1-1</option>
                                    <option value="1-0-0">1-0-0</option>
                                    <option value="1-0-1">1-0-1</option>
                                    <option value="1-1-0">1-1-0</option>
                                    <option value="1-1-1">1-1-1</option>

                                </select>
                            </div>
                            <div class="col-md-2" >
                                <label for="">{{ $websiteLang->where('lang_key','days')->first()->custom_lang }}</label>
                                <select name="day[]" id="" class="form-control">
                                    @for($i=1;$i<=90;$i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>

                            </div>
                            <div class="col-md-2" >
                                <label for="">{{ $websiteLang->where('lang_key','time')->first()->custom_lang }}</label>
                                <select name="time[]" id="" class="form-control">
                                    <option value="After Meal">{{ $websiteLang->where('lang_key','after_meal')->first()->custom_lang }}</option>
                                    <option value="Befor Meal">{{ $websiteLang->where('lang_key','before_meal')->first()->custom_lang }}</option>
                                </select>
                            </div>
                            <div class="col-md-1 btn-row">
                                <button type="button" id="removePrescribeRow" class="btn btn-danger btn-sm ml-2"><i class="fas fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','advice')->first()->custom_lang }}</h6>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="">{{ $websiteLang->where('lang_key','test_des')->first()->custom_lang }}</label>
                        <textarea name="test_description" id="" cols="30" rows="3" class="form-control" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">{{ $websiteLang->where('lang_key','advice')->first()->custom_lang }}</label>
                        <textarea name="advice" id="" cols="30" rows="5" class="form-control" ></textarea>
                    </div>




                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success ml-3">{{ $websiteLang->where('lang_key','save')->first()->custom_lang }}</button>
        </form>



    </div>





@endsection
