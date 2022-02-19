@extends('layout')

@section('script')
    <script src={{ asset('js/howto.js') }} defer></script>
@endsection

@section('main')
    <div class="container mt-5 pt-2">
        <div class="m-2 p-2">
            <h1 class="my-2 py-2 text-decoration-underline">Main Concept</h1>
            <p>It is like putting a component in stack inside a container</p>
            <p>you can rearrange and config these component by yourself with limited configuration</p>
            <p>In this demo, each page act as one container and each functional element act as one component</p>
        </div>
        <div class="m-2 p-2">
            <h1 class="my-2 py-2 text-decoration-underline">Method</h1>
            <ul class="list-group">
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 1</h5>
                        <p>Go to the page of Config</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_1.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="1" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 2</h5>
                        <p>Add a page at the left menu (pointed in the picture beside) and give it a name</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_2.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="2" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 3</h5>
                        <p>A container correspond to the page will be appear at the right menu</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_3.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="3" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 4</h5>
                        <p>In order to add component to your page, head to the page container and click the blue button
                            below there</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_4.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="4" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 5</h5>
                        <p>Decide and select the component the list, then click ok. The new component will appear in the
                            stack list of container</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_5.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="5" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 6</h5>
                        <p>Take note that the order of component in the stack list is represent the order of component at
                            your page</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_6.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="6" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 7</h5>
                        <p>Remove the component by clicking the "X" icon. Config the component by clicking the 3 dot icon
                        </p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_7.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="7" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 8</h5>
                        <p>After complete your component configuration, click "Save Change" button</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_8.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="8" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
                <li class="list-group-item d-flex">
                    <div class="w-50">
                        <h5>Step 9</h5>
                        <p>Once you complete all the configuration, click the "Preview" at the top of the page to preview
                            the page you configured</p>
                    </div>
                    <div class="w-50">
                        <img class="w-100" src="/img/step_9.png" alt="step1">
                        <button type="button" class="btn btn-warning w-100" value="9" data-bs-toggle="modal"
                            data-bs-target="#imgEnlarge">Click to Enlarge</button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="m-2 p-2">
            <h1 class="my-2 py-2 text-decoration-underline">Limitation</h1>
            <p>There is no limitation for adding page and component ....... yet</p>
            <p>Most of the config only involve adjusting component's position, alignment, color and content</p>
            <p>User are not able to attach media file to component</p>
            <p>User are not able to rearrange the order of component in the page container's stack list</p>
        </div>
        <div class="m-2 p-2">
            <h1 class="my-2 py-2 text-decoration-underline">Message</h1>
            <p>Thank you for pay a view here</p>
            <p>Email me if you have any opinion or there is any error in the webpage</p>
        </div>
        <div class="modal fade" id="imgEnlarge" tabindex="-1" aria-labelledby="imgEnlargeLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imgEnlargeLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="enlargeImg" src="" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
