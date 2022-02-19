<div class="container px-5 d-flex flex-column bg-light">
    <form action="/message" method="post">
        @csrf
        <div class="my-5 text-center">
            <h3>This form will submit to your email</h3>
        </div>
        @foreach ($component['props']['Field'] as $i => $field)
            <div class="mb-1">
                <label class="form-label">{{ $field }}</label>
                <input type="text" class="form-control" name="{{ str_replace(' ', '_', $field) }}" />
            </div>
        @endforeach
        <div class="{{ $component['primaryClass'] }}">
            <button class="{{ $component['secondaryClass'] }}" type="submit">Submit</button>
        </div>
    </form>
</div>
