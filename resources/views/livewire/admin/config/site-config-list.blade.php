<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Cấu hình trang
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Cấu hình trang</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-4" >
                            <label class="col-form-label">Tìm kiếm</label>
                            <input wire:model.debounce.1000ms="searchName" placeholder="Tìm kiếm câu hỏi, câu trả lời" type="text" class="form-control">
                        </div>
                        <div class="col-3" >
                            <label class="col-form-label">Loại câu hỏi</label>
                            <select class='form-control' wire:model='searchType'>
                                <option value="">---Chọn loại câu hỏi---</option>
                                @foreach($SiteConfigType as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <button type="button" class="btn btn-outline-primary" wire:click="resetSearch()"><i class="fa fa-undo"></i> Làm mới</button>
                <div>
                    <div style="float: left;text-align: center;">
                        <a href="#" data-toggle="modal" data-target="#modelCreateEdit" wire:click='create'>
                            <div class="btn btn-primary">
                                <i class="fa fa-plus"></i> Tạo mới
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div wire:loading class="loader"></div>
            <table class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                <thead>
                    <tr role='row'>
                        <th class='text-center w-60'>STT</th>
                        <th>type</th>
                        <th>key</th>
                        <th>value</th>
                        <th>value_en</th>
                        <th>order_number</th>
                        <th>image</th>
                        <th class='text-center w-120'>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <td>{{($data->currentPage() - 1) * $data->perPage() + $loop->iteration}}</td>
                            <td>{{$SiteConfigType[$row->type]??''}}</td>
                            <td>{{$row->question}}</td>
                            <td>{!!chuanHoa($row->answer)!!}</td>
                            <td>{{$row->category}}</td>
                            <td>{{$row->order_number}}</td>
                            <td>{{$row->image}}</td>
                            <td class='text-center'>
                                <a  type='button' class='btn btn-primary btn-sm' wire:click='edit({{$row}})' data-toggle='modal' data-target='#modelCreateEdit' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
                                @include('livewire.common.buttons._delete')
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center text-danger">
                            <td colspan="8">Không có bản ghi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $data->links() }}
    </div>

    {{-- Start modal --}}
        <div wire:ignore.self class="modal fade" id="modelCreateEdit" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalLabel">{{$this->mode=='create'?"Thêm mới":($this->mode =='detail'?"Chi tiết":"Chỉnh sửa")}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                wire:click="resetValidate()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style='margin:0 0 5px;'>
                            <label>Type(<span style="color:red">*</span>)</label>
                                <select class='form-control col-6' wire:model.defer='type'>
                                    <option value="">---Chọn loại câu hỏi---</option>
                                    @foreach($SiteConfigType as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            @error('type')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Key</label>
                            <input type="text" class="form-control"
                                placeholder="Key" wire:model.defer="key">
                            @error('key')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Value</label>
                            <textarea rows="4" wire:model='value' class='form-control' placeholder='Value En'></textarea>
                            @error('value')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Value En</label>
                            <textarea rows="4" wire:model='value_en' class='form-control' placeholder='Value En'></textarea>
                            @error('value_en')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>
                        

                        <div class="form-group"  style='margin:0 0 5px;'>
                            <label> Order number</label>
                            <input type="number" class="form-control col-6" oninput="this.value = Math.abs(this.value)"
                                placeholder="Order number" wire:model.defer="order_number">
                            @error('order_number')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal" wire:click="resetValidate()">
                            Đóng
                        </button>
                        <button type="button" @if($mode == 'detail') disabled @endif class="btn btn-primary" wire:click='saveData'>
                            Lưu
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @include('livewire.common._modalDelete')
    {{-- End modal --}}
</div>

<script>
    $("document").ready(() => {
        window.livewire.on('closeModalCreateEdit', () => {
            $('#modelCreateEdit').modal('hide');
        });
    });
</script>
