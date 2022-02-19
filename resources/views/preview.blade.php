@extends('layout')

@section('script')
    <style>
        .preview {
            height: 300px;
        }

        .preview-card {
            height: 100px;
            width: 75px;
            background-color: lightyellow;
        }

        .preview-logo {
            padding-top: 10px;
            height: 50px;
            width: 50px;
            border-radius: 50%;
            background-color: lightpink;
        }

        .preview-container {
            width: 80%;
        }

    </style>
@endsection

@section('main')
    @foreach ($components as $i => $component)
        @switch($component["name"])
            @case('navbar')
                @include('navbar', ["component"=>$component])
            @break
            @case('cards')
                @if ($components[$i - 1]['name'] == 'navbar' && $components[$i - 1]['props']['Hang'])
                    <div class="position-relative">
                        @include('navbar', ["component"=>$components[$i-1]])
                        @include('cards', ["component"=>$component])
                    </div>
                @else
                    @include('cards', ["component"=>$component])
                @endif
            @break
            @case('carousel')
                @if ($components[$i - 1]['name'] == 'navbar' && $components[$i - 1]['props']['Hang'])
                    <div class="position-relative">
                        @include('navbar', ["component"=>$components[$i-1]])
                        @include('carousel', ["component"=>$component])
                    </div>
                @else
                    @include('carousel', ["component"=>$component])
                @endif
            @break
            @case('enquiry')
                @include('enquiry', ["component"=>$component])
            @break
            @default
                <div class="container text-center">
                    <h1>Unknown Component</h1>
                </div>
        @endswitch
    @endforeach
@endsection
