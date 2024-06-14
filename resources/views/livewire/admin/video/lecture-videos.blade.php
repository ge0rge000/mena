<div>
    <div class="container">
        <div class="row card">
            <div class="col-md-12">
                <div class="row mt-4">
                    <div class="col-md-5">
                        <label for="exampleFormControlInput1" class="form-label"> Filter with units</label>
                        <select class="form-select" aria-label="Default select example" id="unid_id" wire:model="unid_id">
                            <option selected>choose unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"> {{ $unit->name }} </option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="col-md-5">
                        <label for="exampleFormControlInput1" class="form-label"> Filter with lectures</label>
                        <select class="form-select" aria-label="Default select example" id="lecture_id" wire:model="lecture_id">
                            <option selected>choose lecture</option>
                            @foreach ($lectures as $lecture)
                                <option value="{{ $lecture['id'] }}"> {{ $lecture['name'] }} </option>
                            @endforeach
                        </select>  
                    </div>
                </div>
                <div class="row mt-4 mb-5">
                    @if ($videos)
                        <h4 class="d-flex justify-content-center mt-2 mb-4">{{ $lecture['name'] }}</h4>
                        <div class="row">
                            @foreach ($videos as $video)
                                <div class="col-md-6">
                                    <div class="row">
                                        <h5 class="d-flex justify-content-center">{{ $video->name_video }}</h5>
                                    </div>
                                    <div class="row">
                                        <iframe src="{{ $video->embed_link }}" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
