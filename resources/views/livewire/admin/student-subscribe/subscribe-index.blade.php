<div>
    <div class="container-fluid">
        <div class="row card">
            <div class="card-header text-center p-2">
                <h5>Student subscriptions</h5>
            </div>
            <div class="card-body">
                @if(!$selectedStudent)
                    <input type="text" class="form-control" wire:model.debounce.500ms="searchTerm" placeholder="Search With Code..." >
                @endif
                @if($results)
                    <ul class="list-group">
                        @foreach($results as $result)
                            <button class="btn btn-info" wire:click="selectStudent({{ $result->id }})" type="button">
                                <li class="list-group-item">
                                    {{ $result->name }} --  {{ $result->mobile_phone }}
                                </li>
                            </button>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    
                </table>
            </div>
        </div>
    </div>
</div>
