<div class="{{$component["primaryClass"]}}">
    @foreach ($component["props"]["Content"] as $card)    
        <div class="{{$component["secondaryClass"]}}">
            <div>{{ $card }}</div>
        </div>
    @endforeach
</div>