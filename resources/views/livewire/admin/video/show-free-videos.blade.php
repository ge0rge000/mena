<div>
    <div class="container-fluid">
        <div class="card">
            <div class="row m-3 ">
                @foreach($freeVideos as $freeVideo)
                <div class="col-md-6">
                    <h4 class="d-flex justify-content-center mb-3">
                        {{ $freeVideo->name }}
                    </h4>
                    <div class="video-container">
                        <iframe width="560" height="315" src="{{ $freeVideo->embed_link }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
