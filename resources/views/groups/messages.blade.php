<div>
    @foreach ($messages as $message)
        <div class="chatItem">
            <div style="border-bottom: 1px solid black;" class="chatuser">
                Sent by {{ $message->user->name }}
            </div>
            <div class="chatText">
                {{ $message->message }}    
            </div>    
        
        </div   >
    @endforeach
</div>