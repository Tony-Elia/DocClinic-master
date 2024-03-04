<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $websiteLang->where('lang_key','payment_history')->first()->custom_lang }}
            <button class="btn btn-success btn-sm print_btn" onclick="printReport()"><i class="fas fa-print    "></i>
        </h6>
    </div>
    <div class="card-body" id="search-appointment">
        <div class="table-responsive printArea">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">{{ $websiteLang->where('lang_key','serial')->first()->custom_lang }}</th>
                        <th width="15%">{{ $websiteLang->where('lang_key','name')->first()->custom_lang }}</th>
                        <th width="15%">{{ $websiteLang->where('lang_key','email')->first()->custom_lang }}</th>
                        <th width="15%">{{ $websiteLang->where('lang_key','phone')->first()->custom_lang }}</th>
                        <th width="5%">{{ $websiteLang->where('lang_key','payment')->first()->custom_lang }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $index => $doctor)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ ucfirst($doctor->name) }}</td>
                        <td>{{ $doctor->email }}</td>
                        <td>{{ $doctor->phone }}</td>
                        @php
                            $total=$appointments->where('doctor_id',$doctor->id)->sum('appointment_fee')
                        @endphp
                        <td>
                            {{ $currency->currency_icon }}{{ $total }}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
