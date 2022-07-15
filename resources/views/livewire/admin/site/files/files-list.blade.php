<div>
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <div class="">
                        <div class="input-group">
                            <input type="text" wire:model.debounce.1000ms="searchTerm" class="form-control-sm form-control custom-input-control" id="searchTerm" placeholder="Search"  name="searchTerm">
                            <div class="input-group-append">
                                <span class="input-group-text" id="keywordAppend">
                                    <div class="text-xs">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </span>
                            </div>
                        </div>
                </div>
            </div>
            
            <table class="table table-striped">
                <thead class="">
                    <tr>
                        <th>STT</th>
                        <th>Model ID</th>
                        <th>Model Name</th>
                        <th>Tên File</th>
                        <th>Dung lượng</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <div wire:loading class="loader"></div>
                <tbody>
                        @foreach($data as $key=> $item)
                            <tr>
                                <td class="align-middle">{{$key+1}}</td>
                                <td class="align-middle">{{$item->model_id}}</td>
                                <td class="align-middle">{{$item->model_name}}</td>
                                <td class="align-middle"><a href="{{$item->url}}" download="{{$item->name}}">{{$item->file_name}}</a></td>
                                <td class="align-middle">{{$item->size_file}} KB</td>
                                <td class="align-middle">{{$item->note}}</td>
                                <td class="align-middle">
                                    <a href="{{route('files.edit',$item->id)}}" 
                                    class="btn-sm border-0 bg-transparent">
                                    <img src="/images/pent2.svg" alt="Edit">
                            </a>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
            @if(!isset($data) || !count($data))
                <div class="pb-2 pt-3 text-center">Không tìm thấy dữ liệu</div>
            @endif
        </div>
        @if(count($data))
            {{ $data->links() }}
        @endif
    </div>
</div>
