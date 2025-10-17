@extends('layouts.app')

@section('styles')
    {{-- <style>
        .lg-image,.sm-image,.md-image,.xl-image{
            padding: 3px;
            width: 100%;
        }
        
        .lg-image{height: 26rem;}
        .sm-image{height: 9rem;}
        .xl-image{height: 30rem;}
        .md-image{height: 13rem;}
        
        
        @media screen and (max-width: 750px) {
            .lg-image{height: 15rem;}
            .sm-image{height: 5rem;}
            .xl-image{height: 20rem;}
            .md-image{height: 7.5rem;}
        }
        
        .active {
            scale: 0.8
        }
        .log_btn {
            background-color: #05445E;
            transition: 0.7s;
            color: #fff;
        }
        .log_btn:hover {
            background-color: #189AB4;
            color: #fff;
        }
    </style> --}}
@endsection

@section('content')
    <section>
        <div class="container">
            
        <div class="row ml-md-5">
            
            <div class="col-md-6 ml-md-5 ml-2 col-11" id="image_grid">
            </div>
        
            <div class="col-md-2 col-12 mt-2">
                <button type="button" class="btn btn-primary w-100 mb-1" onclick="setGridStyle(1)">
                    <svg xmlns="http://www.w3.org/2000/svg" style="transform: rotate(-180deg);" class="icon icon-tabler icon-tabler-table" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path>
                        <path d="M3 10h18"></path>
                        <path d="M10 3v18"></path>
                    </svg>
                
                </button>
                <button type="button" class="btn btn-primary w-100 mb-1" onclick="setGridStyle(2)">
                    <svg xmlns="http://www.w3.org/2000/svg" style="transform: rotate(-90deg);" class="icon icon-tabler icon-tabler-table" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path>
                        <path d="M3 10h18"></path>
                        <path d="M10 3v18"></path>
                    </svg>
                </button>
                <button type="button" class="btn btn-primary w-100 mb-1" onclick="setGridStyle(3)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                        <path d="M4 15l16 0"></path>
                    </svg>
                
                </button>
                <button type="button" class="btn btn-primary w-100 mb-1" onclick="setGridStyle(4)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-board" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                        <path d="M4 9h8"></path>
                        <path d="M12 15h8"></path>
                        <path d="M12 4v16"></path>
                    </svg>
                </button>
                <button type="button" class="btn btn-primary w-100" onclick="setGridStyle(5)">
                    <svg xmlns="http://www.w3.org/2000/svg" style="transform: rotate(90deg);" class="icon icon-tabler icon-tabler-grip-vertical" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                        <path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                    </svg>
                </button>
                <button class="btn btn-primary w-100 mt-2 btn-disabled" disabled="" id="swipImages">
                    swip images
                </button>
                <span>Select images to swip<!--.span-->
            </span></div>
        </div>
        <div class="">
            <button class="btn btn-block font-weight-bold log_btn btn-lg " id="downloadCanvas">Download Image</button>
            <!--<button class="btn btn-block font-weight-bold log_btn btn-lg " id="downloadPDF">Download PDF</button>-->
        </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    {{-- <script>
        var variableA = '';
        var variableB = '';
        var images = @json($imagesWithUrls);
        // console.log(images);
        var s3Base = 'https://spms-property.s3.ap-southeast-2.amazonaws.com/';
        images = images.map(img => {
            var path = img.replace(/^https?:\/\/[^/]+\//, ''); 
            return s3Base + path;
        });
        var placeholder = "{{ asset('assets/logos/spms-nav-logo.png') }}"

        function setGridStyle(id) {
            var container = $('#image_grid');
            container.empty();
    
            if (id === 1) {
                container.append(`
                    <div class="row">
                        <div class="col-8 p-0">
                            <img src="${images[0] ?? placeholder}" class="lg-image" alt="">
                            <div class="d-flex">
                                <img src="${images[1] ?? placeholder}" class="md-image w-50 draggable-image" alt="">
                                <img src="${images[2] ?? placeholder}" class="md-image w-50 draggable-image" alt="">
                            </div>
                        </div>
                        <div class="col-4 p-0">
                            <div class="row h-100 flex-column">
                                <div class="col">
                                    <img src="${images[3] ?? placeholder}" class="md-image draggable-image" alt="">
                                </div>
                                <div class="col">
                                    <img src="${images[4] ?? placeholder}" class="md-image draggable-image" alt="">
                                </div>
                                <div class="col">
                                    <img src="${images[5] ?? placeholder}" class="md-image draggable-image" alt="">
                                </div>
                            </div>
                        </div>
                    </div>`);
            }
    
            if (id === 2) {
                container.append(`
                    <div class="row">
                        <div class="col-4 p-0">
                            <div class="row h-100 flex-column">
                                <div class="col">
                                    <img src="${images[0] ?? placeholder}" class="md-image" alt="">
                                </div>
                                <div class="col">
                                    <img src="${images[1] ?? placeholder}" class="md-image" alt="">
                                </div>
                                <div class="col">
                                    <img src="${images[2] ?? placeholder}" class="md-image" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-8 p-0">
                            <img src="${images[3] ?? placeholder}" class="lg-image" alt="">
                            <div class="d-flex">
                                <img src="${images[4] ?? placeholder}" class="md-image w-50" alt="">
                                <img src="${images[5] ?? placeholder}" class="md-image w-50" alt="">
                            </div>
                        </div>
                    </div>`);
            }
    
            if (id === 3) {
                container.append(`
                    <div class="row">
                        <div class="col-12 p-0">
                            <img src="${images[0] ?? placeholder}" class="xl-image" alt="">
                        </div>
                        <div class="col-3 p-0">
                            <img src="${images[1] ?? placeholder}" class="sm-image" alt="">
                        </div>
                        <div class="col-3 p-0">
                            <img src="${images[2] ?? placeholder}" class="sm-image" alt="">
                        </div>
                        <div class="col-3 p-0">
                            <img src="${images[3] ?? placeholder}" class="sm-image" alt="">
                        </div>
                        <div class="col-3 p-0">
                            <img src="${images[4] ?? placeholder}" class="sm-image" alt="">
                        </div>
                    </div>`);
            }
    
            if (id === 4) {
                container.append(`
                    <div class="row">
                        <div class="col-4 p-0">
                            <img src="${images[0] ?? placeholder}" class="md-image" />
                            <img src="${images[1] ?? placeholder}" class="lg-image" />
                        </div>
                        <div class="col-4 p-0">
                            <img src="${images[2] ?? placeholder}" class="lg-image" />
                            <img src="${images[3] ?? placeholder}" class="md-image" />
                        </div>
                        <div class="col-4 p-0">
                            <img src="${images[4] ?? placeholder}" class="md-image" />
                            <img src="${images[5] ?? placeholder}" class="lg-image" />
                        </div>
                    </div>`);
            }
    
            if (id === 5) {
                container.append(`
                    <div class="row">
                        <div class="col-4 p-0">
                            <img src="${images[0] ?? placeholder}" class="md-image" />
                        </div>
                        <div class="col-4 p-0">
                            <img src="${images[1] ?? placeholder}" class="md-image" />
                        </div>
                        <div class="col-4 p-0">
                            <img src="${images[2] ?? placeholder}" class="md-image" />
                        </div>
                        <div class="col-4 p-0">
                            <img src="${images[3] ?? placeholder}" class="md-image" />
                        </div>
                        <div class="col-4 p-0">
                            <img src="${images[4] ?? placeholder}" class="md-image" />
                        </div>
                        <div class="col-4 p-0">
                            <img src="${images[5] ?? placeholder}" class="md-image" />
                        </div>
                    </div>`);
            }
    
            if (variableA) {
                container.find('img[src="' + variableA + '"]').addClass('active1');
            }
            if (variableB) {
                container.find('img[src="' + variableB + '"]').addClass('active1');
            }
        }
    
        $(document).ready(function() {
            setGridStyle(1);
    
            $('#downloadCanvas').on('click', function (e) {
                e.preventDefault();
    
                const element = document.getElementById('image_grid');
                html2canvas(element, { useCORS: true }).then(function (canvas) {
                    const pngImage = canvas.toDataURL('image/png');
                    const pngLink = document.createElement('a');
                    pngLink.href = pngImage;
                    pngLink.download = 'canvas_image.png';
                    pngLink.click();
                });
            });
    
            $(document).on('click', '#image_grid img', function() {
                var src = $(this).attr("src");
    
                $("#image_grid img").removeClass("active1");
    
                if (variableA === "") {
                    variableA = src;
                    // console.log(src);
                } else if (variableB === "") {
                    variableB = src;
                    $("#swipImages").prop('disabled', false);
                } else {
                    variableA = src;
                    $("#swipImages").prop('disabled', false);
                }
    
                $("#image_grid img[src='" + variableA + "']").addClass('active1');
                $("#image_grid img[src='" + variableB + "']").addClass('active1');
            });
    
            $("#swipImages").click(function() {
                let x = variableA;
                let y = variableB;
    
                let AImage = $("#image_grid img[src='" + x + "']");
                let BImage = $("#image_grid img[src='" + y + "']");
    
                AImage.prop('src', y);
                BImage.prop('src', x);
                $('#image_grid .active1').removeClass('active1');
                variableA = '';
                variableB = '';
                $("#swipImages").prop('disabled', true);
            });
        });
    </script> --}}
 <script>
    var variableA = '';
    var variableB = '';
    var images = @json($imagesWithUrls);
    // var s3Base = 'https://spms-property.s3.ap-southeast-2.amazonaws.com/';
    // images = images.map(img => {
    //     var path = img.replace(/^https?:\/\/[^/]+\//, ''); 
    //     return s3Base + path;
    // });
    var placeholder = "{{ asset('assets/logos/spms-nav-logo.png') }}"

    function setGridStyle(id) {
        var container = $('#image_grid');
        container.empty();

        if (id === 1) {
            container.append(`
                <div class="row">
                    <div class="col-8 p-0">
                        <img src="${images[0] ?? placeholder}" class="lg-image" data-index="0" alt="">
                        <div class="d-flex">
                            <img src="${images[1] ?? placeholder}" class="md-image w-50 draggable-image" data-index="1" alt="">
                            <img src="${images[2] ?? placeholder}" class="md-image w-50 draggable-image" data-index="2" alt="">
                        </div>
                    </div>
                    <div class="col-4 p-0">
                        <div class="row h-100 flex-column">
                            <div class="col">
                                <img src="${images[3] ?? placeholder}" class="md-image draggable-image" data-index="3" alt="">
                            </div>
                            <div class="col">
                                <img src="${images[4] ?? placeholder}" class="md-image draggable-image" data-index="4" alt="">
                            </div>
                            <div class="col">
                                <img src="${images[5] ?? placeholder}" class="md-image draggable-image" data-index="5" alt="">
                            </div>
                        </div>
                    </div>
                </div>`);
        }

        if (id === 2) {
            container.append(`
                <div class="row">
                    <div class="col-4 p-0">
                        <div class="row h-100 flex-column">
                            <div class="col">
                                <img src="${images[0] ?? placeholder}" class="md-image" data-index="0" alt="">
                            </div>
                            <div class="col">
                                <img src="${images[1] ?? placeholder}" class="md-image" data-index="1" alt="">
                            </div>
                            <div class="col">
                                <img src="${images[2] ?? placeholder}" class="md-image" data-index="2" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-8 p-0">
                        <img src="${images[3] ?? placeholder}" class="lg-image" data-index="3" alt="">
                        <div class="d-flex">
                            <img src="${images[4] ?? placeholder}" class="md-image w-50" data-index="4" alt="">
                            <img src="${images[5] ?? placeholder}" class="md-image w-50" data-index="5" alt="">
                        </div>
                    </div>
                </div>`);
        }

        if (id === 3) {
            container.append(`
                <div class="row">
                    <div class="col-12 p-0">
                        <img src="${images[0] ?? placeholder}" class="xl-image" data-index="0" alt="">
                    </div>
                    <div class="col-3 p-0">
                        <img src="${images[1] ?? placeholder}" class="sm-image" data-index="1" alt="">
                    </div>
                    <div class="col-3 p-0">
                        <img src="${images[2] ?? placeholder}" class="sm-image" data-index="2" alt="">
                    </div>
                    <div class="col-3 p-0">
                        <img src="${images[3] ?? placeholder}" class="sm-image" data-index="3" alt="">
                    </div>
                    <div class="col-3 p-0">
                        <img src="${images[4] ?? placeholder}" class="sm-image" data-index="4" alt="">
                    </div>
                </div>`);
        }

        if (id === 4) {
            container.append(`
                <div class="row">
                    <div class="col-4 p-0">
                        <img src="${images[0] ?? placeholder}" class="md-image" data-index="0" />
                        <img src="${images[1] ?? placeholder}" class="lg-image" data-index="1" />
                    </div>
                    <div class="col-4 p-0">
                        <img src="${images[2] ?? placeholder}" class="lg-image" data-index="2" />
                        <img src="${images[3] ?? placeholder}" class="md-image" data-index="3" />
                    </div>
                    <div class="col-4 p-0">
                        <img src="${images[4] ?? placeholder}" class="md-image" data-index="4" />
                        <img src="${images[5] ?? placeholder}" class="lg-image" data-index="5" />
                    </div>
                </div>`);
        }

        if (id === 5) {
            container.append(`
                <div class="row">
                    <div class="col-4 p-0">
                        <img src="${images[0] ?? placeholder}" class="md-image" data-index="0" />
                    </div>
                    <div class="col-4 p-0">
                        <img src="${images[1] ?? placeholder}" class="md-image" data-index="1" />
                    </div>
                    <div class="col-4 p-0">
                        <img src="${images[2] ?? placeholder}" class="md-image" data-index="2" />
                    </div>
                    <div class="col-4 p-0">
                        <img src="${images[3] ?? placeholder}" class="md-image" data-index="3" />
                    </div>
                    <div class="col-4 p-0">
                        <img src="${images[4] ?? placeholder}" class="md-image" data-index="4" />
                    </div>
                    <div class="col-4 p-0">
                        <img src="${images[5] ?? placeholder}" class="md-image" data-index="5" />
                    </div>
                </div>`);
        }

        if (variableA !== '') {
            container.find('img[data-index="' + variableA + '"]').addClass('active1');
        }
        if (variableB !== '') {
            container.find('img[data-index="' + variableB + '"]').addClass('active1');
        }
    }

    $(document).ready(function() {
        setGridStyle(1);

        // $('#downloadCanvas').on('click', function (e) {
        //     e.preventDefault();
        //     const element = document.getElementById('image_grid');
        //     html2canvas(element, { useCORS: true }).then(function (canvas) {
        //         const pngImage = canvas.toDataURL('image/png');
        //         const pngLink = document.createElement('a');
        //         pngLink.href = pngImage;
        //         pngLink.download = 'canvas_image.png';
        //         pngLink.click();
        //     });
        // });
        $('#downloadCanvas').on('click', function (e) {
            e.preventDefault();
        
            // Replace each image src with the proxied version
            // $("#image_grid").find("img").each(function() {
            //     const originalSrc = $(this).prop('src');
            //     $(this).prop('src', "{{ route('proxy.s3.image') }}?url=" + encodeURIComponent(originalSrc));
            // });
            $('#downloadCanvas').html("Please Wait...").css({opacity: .5})
            // Wait a bit for images to reload
            setTimeout(function() {
                const element = document.getElementById('image_grid');
                html2canvas(element, { useCORS: true }).then(function (canvas) {
                    const pngImage = canvas.toDataURL('image/png');
                    const pngLink = document.createElement('a');
                    pngLink.href = pngImage;
                    pngLink.download = 'canvas_image.png';
                    pngLink.click();
                    $('#downloadCanvas').html("Download Image").css({opacity: 1})
                });
            }, 500); // half a second (adjust if needed)
        });

        $(document).on('click', '#image_grid img', function() {
            var index = $(this).data("index");

            $("#image_grid img").removeClass("active1");

            if (variableA === "") {
                variableA = index;
            } else if (variableB === "") {
                variableB = index;
                $("#swipImages").prop('disabled', false);
            } else {
                variableA = index;
                $("#swipImages").prop('disabled', false);
            }

            $("#image_grid img[data-index='" + variableA + "']").addClass('active1');
            $("#image_grid img[data-index='" + variableB + "']").addClass('active1');
        });

        $("#swipImages").click(function() {
            let AImage = $("#image_grid img[data-index='" + variableA + "']");
            let BImage = $("#image_grid img[data-index='" + variableB + "']");

            let tempSrc = AImage.attr("src");
            AImage.attr("src", BImage.attr("src"));
            BImage.attr("src", tempSrc);

            $('#image_grid .active1').removeClass('active1');
            variableA = '';
            variableB = '';
            $("#swipImages").prop('disabled', true);
        });
    });
</script>

@endsection