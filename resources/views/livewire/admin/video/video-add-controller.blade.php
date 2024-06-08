<div>
    <style>
        span.error {
            color: red;
        }
    </style>
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Upload File</h5>
                    </div>

                    <div class="card-body">
                        <form wire:submit.prevent="store">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Video title</label>
                                <input type="text" class="form-control" wire:model="title" id="exampleFormControlInput1" placeholder="enter video title">
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea class="form-control" wire:model="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="exampleFormControlInput1" class="form-label">Video link</label>
                                <input type="text" class="form-control" wire:model="link" id="exampleFormControlInput1" placeholder="enter video link">
                                @error('link')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>                            
                            <div class="mt-3">
                                <select class="form-select" aria-label="Default select example" wire:model="selectedUnit" >
                                    <option selected>Open this select menu</option>
                                    @foreach ($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="mt-3">
                                <select class="form-select" aria-label="Default select example" wire:model="selectedLecture" >
                                    <option selected>Select lecture</option>
                                    @foreach ($lectures as $lecture)
                                        <option value="{{$lecture->id}}">{{$lecture->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br> <br>
                            <button type="submit" class="btn btn-sm btn-block btn-danger">Upload</button>
                        </form>      
                    </div>
                    <!-- <button type="submit" wire:click="get" class="btn btn-sm btn-block btn-danger">get</button> -->


                    <!-- <video width="700" height="500" controls>
                        <source src="https://drive.google.com/uc?export=download&id=1q4xILol14D5WJzIguYJY9Wkesaf7vlFA" type="video/mp4">
                        Your browser does not support the video tag.
                    </video> -->
                    
                    <!-- display video with specific id from data base   -->
 
                    <!-- <iframe src="https://drive.google.com/uc?export=download&id=1q4xILol14D5WJzIguYJY9Wkesaf7vlFA"
                    width="640" height="480" frameborder="0" allowfullscreen></iframe> -->
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/livewire@2.7.2/dist/livewire.js"></script>
    <script type="text/javascript">
            let browseFile = $('#browseFile');

            let resumable = new Resumable({
                target: '{{ route('upload.video') }}',
                query:{_token:'{{ csrf_token() }}'} ,// CSRF token
                fileType: ['mp4'],
                chunkSize: 10*1024*1024, // default is 1*1024*1024, this should be less than your maximum limit in php.ini
                headers: {
                    'Accept' : 'application/json'
                },
                testChunks: false,
                throttleProgressCallbacks: 1,
            });

            resumable.assignBrowse(browseFile[0]);

            resumable.on('fileAdded', function (file) { // trigger when file picked
                console.log('fileAdded' , file);
                showProgress();
                resumable.upload() // to actually start uploading.
            });

            resumable.on('fileProgress', function (file) { // trigger when file progress update
                updateProgress(Math.floor(file.progress() * 100));
            });

            resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
                response = JSON.parse(response)
                resumable.removeFile(file);

                console.log('Success response:' , response , response.path);
              //  $('#videoPreview').attr('src', response.path);

                @this.set('video_id' , response.video_id)
                @this.set('case_video' , "1")

                $('.card-footer').show();
            });

            resumable.on('fileError', function (file, response) { // trigger when there is any error
                console.log(response);
                alert('file uploading error.')
            });


            let progress = $('.progress');
            function showProgress() {
                progress.find('.progress-bar').css('width', '0%');
                progress.find('.progress-bar').html('0%');
                progress.find('.progress-bar').removeClass('bg-success');
                progress.show();
            }

            function updateProgress(value) {
                progress.find('.progress-bar').css('width', `${value}%`)
                progress.find('.progress-bar').html(`${value}%`)
            }

            function hideProgress() {
                progress.hide();
            }
            const inputElement = document.querySelector('input[id="avatar"]');

            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                server:{
                    url:'/addvideo/{year}',
                    headers:{
                        'X-CSRF-TOKEN':'{{csrf_token()}}'
                    }

                }
            })
    </script>

    @endpush



  <script>

    $(document).ready(function () {

        $('#select2-dropdown').select2();
        $('#select2-dropdown').on('change', function (e) {
            var data = $('#select2-dropdown').select2("val");
            @this.set('unit_selected', data);
        });
    });
</script>


</div>
