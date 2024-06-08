<div>
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
            @if(Session::has('success_message'))
                <div class="alert alert-success">
                    {{Session::get('success_message')}}
                </div>
            @endif
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Create new student</h5>
                    </div>

                    <div class="card-body">
                        <form wire:submit.prevent="store" enctype="multipart/form-data"  id="addStudent">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">student name</label>
                                <input type="text" class="form-control" wire:model="name" id="exampleFormControlInput1" placeholder="enter student name">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">father's mobile</label>
                                <input type="number" class="form-control" wire:model="mobile_father" id="exampleFormControlInput1" placeholder="enter student name">
                                @error('mobile_father')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label"> case</label>
                                <select class="form-select" aria-label="Default select example" id="month" wire:model="case">
                                    <option value="0" selected>case</option>
                                        <option value="0">Unpaid </option>
                                        <option value="1">Paid</option>
                                </select>  
                                @error('case')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>       
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">year type </label>
                                <select class="form-select" aria-label="Default select example" id="month" wire:model="year">
                                    <option value="0" selected>year</option>
                                    @foreach ($year_type as $year)
                                        <option value="{{ $year }}">{{$year}}</option>
                                    @endforeach
                                </select>  
                                @error('case')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>       
                            
                        </form> 
                        <label for="exampleFormControlInput1" class="form-label">student code</label>
                        <div class="mb-3 d-flex " wire:ignore.self>
                            <input type="text" class="form-control" wire:model="code" id="exampleFormControlInput1" placeholder="student code generatopn">
                            <button class="btn btn-success" wire:click="generateUniqueCode">Generate</button>
                            @error('code')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <br>
                        <button type="submit" class="btn btn-sm btn-block btn-danger" form="addStudent">Store</button>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
