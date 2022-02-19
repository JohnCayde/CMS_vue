<div class="{{ $component['primaryClass'] }}" style="{{ $component['props']['Hang'] ? 'top:35px;z-index:2;' : '' }}">
    @if ($component['props']['Logo'])
        <div class="preview-logo text-center">Logo</div>
        <div class="d-flex ms-5">
            @foreach ($component['props']['Hyperlink'] as $prop)
                <a href="/preview/{{ $prop->code }}" class="{{ $component['secondaryClass'] }}">{{ $prop->name }}</a>
            @endforeach
        </div>
    @else
        @foreach ($component['props']['Hyperlink'] as $prop)
            <a href="/preview/{{ $prop->code }}" class="{{ $component['secondaryClass'] }}">{{ $prop->name }}</a>
        @endforeach
    @endif
</div>
