<section class="home-slider position-relative">
    <div id="carouselExampleInterval" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach(\App\Models\CarouselItem::all() as $item)
                <div class="carousel-item {{$loop->first ? 'active' : ''}}" data-bs-interval="3000">
                    <div class="bg-home slider-rtl-2 d-flex align-items-center"
                         style="background:url('{{$item->getFirstMediaUrl('carousel_images')}}') center center;">
                        <div class="container">
                            <div class="row align-items-center mt-5">
                                <div class="col-lg-7 col-md-7">
                                    <div class="title-heading mt-4">
                                        <h1 class="display-4 title-white fw-bold mb-3">{{$item->title}}</h1>
                                        <p class="para-desc text-muted para-dark">
                                            {{$item->text}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">قبلی </span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">بعدی </span>
        </a>
    </div>
</section>
