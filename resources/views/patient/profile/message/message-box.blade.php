<div class="message-wrapper">
    <ul class="messages">
        @foreach($messages as $message)
            <li class="message clearfix">
                {{--if message from id is equal to auth id then it is sent by logged in user --}}
                <div class="{{ ($message->send_user == Auth::guard('web')->user()->id) ? 'sent' : 'received' }}">
                    <p>{{ $message->message }}</p>
                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                </div>
            </li>
        @endforeach

    </ul>
</div>

<div class="input-text">
    <div class="row">
        <div class="col-md-10">
            <input type="text" name="message" class="submit">
        </div>
        <div class="col-md-2">
            <button class="btn btn-success" id="sentMessageBtn" onclick="sendMessage()" disabled>{{ $websiteLang->where('lang_key','send')->first()->custom_lang }}</button>
        </div>
    </div>


</div>
