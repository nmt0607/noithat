<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Cấu hình chung
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Cấu hình chung</div>
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
                            <input wire:model.debounce.1000ms="search" placeholder="Tìm kiếm" type="text" class="form-control">
                        </div>
                        <div class="col-2" wire:ignore>
                            <label class="col-form-label">Chọn value type</label>
                            <select wire:model.debounce.1000ms="typeFilter" class="form-control select2-box">
                                <option value=''>
                                    {{'---'.__('master/masterManager.menu_name.type').'---'}}
                                </option>
                                @foreach($dataType as $key => $item)
                                    <option value='{{$key}}'>
                                        {{$item}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <hr>
                </div>
            </div>

            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <button type="button" class="btn btn-outline-primary" style='visibility:hidden;' wire:click="resetSearch()"><i class="fa fa-undo"></i> Làm mới</button>
                <div>
                    <div style="float: left;text-align: center;">
                        <a href="#" data-toggle="modal" data-target="#createModal" wire:click='resetform'>
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
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.ID')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.vkey')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">URL</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.type')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.vvalue')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.content')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.note')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.ordernumber')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Number Value</th>
                        <th>{{__('master/masterManager.menu_name.master_title_table.image')}}</th>
                        <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1">{{__('master/masterManager.menu_name.master_title_table.action')}}</th>
                    </tr>
                </thead>
                <tbody  wire:sortable="updateOrder" >
                    @forelse($category as $row)
                        <tr  @if($typeFilter )wire:sortable.item="{{$row->order_number}}" wire:sortable.handle @endif  class="odd" wire:key="master-{{$row->id}}">
                            <td class="dtr-control sorting_1">{{$row->id}}</td>
                            <td>{!! boldTextSearch($row->v_key, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->url, $searchTerm) !!}</td>
                            <td>{{\App\Enums\EMasterData::valueToName($row->type)}}</td>
                            <td>{!! boldTextSearch($row->v_value, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->v_content, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->note, $searchTerm) !!}</td>
                            <td>{{$row->order_number}}</td>
                            <td>{{$row->number_value}}</td>
                            <td>
                                @if(!empty($row->image))
                                    <img src="{{Storage::disk('s3')->url($row->image)}}" alt="" width="70px" height="70px">
                                    @else
                                        No image
                                    @endif
                            </td>
                            <td wire:sortable.stop>
                                <a  type='button' class='btn btn-primary btn-sm' data-toggle="modal" data-target="#editModal" wire:click='edit({{ $row->id }})' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
                                @include('livewire.common.buttons._delete')
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center text-danger">
                            <td colspan="11">Không có bản ghi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $category->links() }}
    </div>
    {{-- Start modal --}}
    @include('livewire.admin.config._modalCreate')
    @include('livewire.admin.config._modalEdit')
    @include('livewire.common._modalDelete')
    {{-- End modal --}}
</div>


<script>
    $("document").ready(() => {
        $('#content').summernote('code', '');
        $('#content_en').summernote('code', '');
        $('#note').summernote('code', '');
        $('#note_en').summernote('code', '');
        window.livewire.on('close-modal-create', () => {
            $('#close-modal-create').click();
            document.getElementById('file-create').value= null;
        });
        window.livewire.on('close-modal-edit', () => {
            $('#close-modal-edit').click();
            document.getElementById('image_edit').value= null;
        });
        window.livewire.on('resetImage', () => {
            document.getElementById('image_edit').value= null;
            document.getElementById('file-create').value= null;
        });
        window.livewire.on('setEditorCreate', () => {
            $('#note').summernote('code', '');
            $('#note_en').summernote('code', '');
            $('#content').summernote('code', '');
            $('#content_en').summernote('code', '');
        });
        window.livewire.on('setEditor', (note, note_en,content, content_en) => {
            $('#note_edit').summernote('code', note);
            $('#note_en_edit').summernote('code', note_en);
            $('#content_edit').summernote('code', content);
            $('#content_en_edit').summernote('code', content_en);
        });
        $('#btn-save').click(function() {
            window.livewire.emit('set-note-create', $('#note').summernote('code'), $('#note_en').summernote('code'),$('#content').summernote('code'), $('#content_en').summernote('code'));
        })
        $('#btn-update').click(function() {
            window.livewire.emit('set-note-update', $('#note_edit').summernote('code'), $('#note_en_edit').summernote('code'),$('#content_edit').summernote('code'), $('#content_en_edit').summernote('code'));
        })

        $(".select2-box").on('change',function(){
            var data=$(".select2-box").select2("val");
            @this.set('typeFilter',data);
        });

    });
</script>
