


@extends('project.cms.layout')

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
    @foreach ($components as $i=> $component)
        @switch($component["name"])
            @case("navbar")
                @if (!$component["props"]["Hang"])
                    @include('project.cms.navbar', ["component"=>$component])
                @endif
                @break
            @case("cards")
                @if ($components[$i-1]["name"]=="navbar" && $components[$i-1]["props"]["Hang"])
                    <div class="position-relative">
                        @include('project.cms.navbar', ["component"=>$components[$i-1]])
                        @include('project.cms.cards', ["component"=>$component])
                    </div>
                @else
                    @include('project.cms.cards', ["component"=>$component])
                @endif
                @break
            @case("carousel")
                @if ($components[$i-1]["name"]=="navbar" && $components[$i-1]["props"]["Hang"])
                    <div class="position-relative">
                        @include('project.cms.navbar', ["component"=>$components[$i-1]])
                        @include('project.cms.carousel', ["component"=>$component])
                    </div>
                @else
                    @include('project.cms.carousel', ["component"=>$component])
                @endif
                @break
            @case("enquiry")
                @include('project.cms.enquiry', ["component"=>$component])
                @break
            @default
                <div class="container text-center">
                    <h1>Unknown Component</h1>
                </div>
        @endswitch
    @endforeach
@endsection