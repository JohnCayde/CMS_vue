<div class="container" style="height:500px">
    <div id="ret" class="carousel slide h-100" data-bs-ride="carousel">
        <div class="carousel-inner h-100">
            @foreach ($component['props']['Content'] as $i => $content)
                @if ($i == 0)
                    <div class="carousel-item h-100 container bg-info active">
                        <div class="{{ $component['primaryClass'] }}">
                            <div class="preview-card w-50 d-flex align-items-center bg-warning m-3 p-5 fs-1">{{$content}}</div>
                        </div>
                    </div>
                @else
                    <div class="carousel-item h-100 container bg-info">
                        <div class="{{ $component['primaryClass'] }}">
                            <div class="preview-card w-50 d-flex align-items-center bg-warning m-3 p-5 fs-1">{{$content}}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#ret" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#ret" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
