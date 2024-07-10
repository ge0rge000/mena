<div>
    @push('style')
        <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
        <style>
            a.ytp-watermark.yt-uix-sessionlink {
                display: none !important;
            }
            .ytp-chrome-top.ytp-show-cards-title {
                display: none !important;
            }
        </style>
    @endpush
    <div class="container">
        <div class="row card">
            <div class="col-md-12">
                <div class="row mt-4">
                    <div class="col-md-5">
                        <label for="exampleFormControlInput1" class="form-label">Filter with units</label>
                        <select class="form-select" aria-label="Default select example" id="unid_id" wire:model="unid_id">
                            <option selected>choose unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"> {{ $unit->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="exampleFormControlInput1" class="form-label">Filter with lectures</label>
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
                                        <div class="plyr__video-embed">
                                            <iframe src="{{ $video->embed_link }}?rel=0&controls=0&modestbranding=1&showinfo=0&iv_load_policy=3" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                                        </div>
                                        <br>
                                        <div class="col-md-5">
                                            <div class="row d-flex flex-row">
                                                <a href="{{ route('video_edit', $video->id) }}" class="btn btn-warning m-3 col-md-6">Edit</a>
                                                <button class="btn btn-danger m-3 col-md-6" wire:click="confirmDeletion({{ $video->id }})">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.plyr.io/3.6.8/plyr.polyfilled.js"></script>
        <script>
            document.addEventListener('livewire:load', () => {
                Livewire.hook('message.processed', (message, component) => {
                    const players = Array.from(document.querySelectorAll('.plyr__video-embed')).map(p => new Plyr(p));
                });
            });

            Livewire.on('confirmDeletion', videoId => {
                if (confirm('Are you sure you want to delete this video?')) {
                    Livewire.emit('deleteVideo', videoId);
                }
            });
        </script>
    @endpush
</div>
