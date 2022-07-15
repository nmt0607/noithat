<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Danh sách người dùng
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Người dùng</div>
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
                            <input wire:model.debounce.1000ms="searchName" placeholder="Họ và tên, Email" type="text" class="form-control">
                        </div>
                        
                        <div class="col-2" >
                            <label class="col-form-label">Số điện thoại</label>
                            <input wire:model.debounce.1000ms="searchPhone" placeholder="Số điện thoại" type="text" class="form-control" readonly="" onfocus="this.removeAttribute('readonly');">
                        </div>
                        <div class="col-2" >
                            <label class="col-form-label">Giới tính</label>
                            <select wire:model='searchSex' class='form-control'>
                                <option value="">--- Chọn giới tính ---</option>
                                <option value="1">Nam</option>
                                <option value="2">Nữ</option>
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
                            <a href="#" data-toggle="modal" data-target="#modelCreateEditTicket" wire:click='create'>
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

                        <th class="{{ $key_name == 'name' ? ($sortingName == 'desc' ? 'sorting_desc' : 'sorting_asc') : 'sorting' }}" wire:click="sorting('name')">Họ và tên</th>
                        <th class="{{ $key_name == 'phone' ? ($sortingName == 'desc' ? 'sorting_desc' : 'sorting_asc') : 'sorting' }}" wire:click="sorting('phone')">Số điện thoại</th>
                        <th class="{{ $key_name == 'email' ? ($sortingName == 'desc' ? 'sorting_desc' : 'sorting_asc') : 'sorting' }}" wire:click="sorting('email')">Email</th>
                        <th class="{{ $key_name == 'date' ? ($sortingName == 'desc' ? 'sorting_desc' : 'sorting_asc') : 'sorting' }}" wire:click="sorting('date')">Ngày sinh</th>
                        <th class="{{ $key_name == 'sex' ? ($sortingName == 'desc' ? 'sorting_desc' : 'sorting_asc') : 'sorting' }}" wire:click="sorting('sex')">Giới tính</th>
                        <th class='text-center w-120'>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <td class='text-center'>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{!! boldTextSearchV2($row->name, $searchName) !!}</td>
                            <td>{!! boldTextSearchV2($row->phone, $searchPhone) !!}</td>
                            <td>{!! boldTextSearchV2($row->email, $searchName) !!}</td>
                            <td>{{ reFormatDate($row->date) }}</td>
                            <td>{{ $row->sex == 1 ?'Nam':($row->sex == 2?'Nữ':'')}}</td>
                            <td class='text-center'>
                                <a  type='button' class='btn btn-primary btn-sm' data-toggle="modal" data-target="#modelCreateEditTicket" wire:click='edit({{ $row }})' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
                                @include('livewire.common.buttons._delete')
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center text-danger">
                            <td colspan="7">Không có bản ghi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $data->links() }}
    </div>
    {{-- Start modal --}}
    <div wire:ignore.self class="modal fade" id="modelCreateEditTicket" tabindex="-1" role="dialog"
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
                    <div class="form-group">
                        <label> Họ và tên(<span style="color:red">*</span>)</label>
                        <input @if($mode == 'detail') disabled @endif  type="text" class="form-control"
                               placeholder="Họ và tên" wire:model.defer="name">
                        @error('name')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="form-group">
                        <label> Mật khẩu @if ($mode == 'create')(<span style="color:red">*</span>) @endif</label>
                        <input @if($mode == 'detail') disabled @endif type="password" class="form-control"
                               placeholder="Mật khẩu" wire:model.defer="password">
                        @error('password')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="form-group">
                        <label> Số điện thoại(<span style="color:red">*</span>)</label>
                        <input @if($mode == 'detail') disabled @endif type="text" class="form-control" placeholder="Số điện thoại"
                               wire:model.defer="phone">
                        @error('phone')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="form-group">
                        <label> Email(<span style="color:red">*</span>)</label>
                        <input @if($mode == 'detail') disabled @endif type="text" class="form-control"
                               placeholder="Email" wire:model.defer="email">
                        @error('email')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="form-group">
                        <label> Ngày sinh(<span style="color:red">*</span>)</label>
                        <input @if($mode == 'detail') disabled @endif type="date" class="form-control"
                               placeholder="Ngày sinh" wire:model.defer="date">
                        @error('date')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="form-group">
                        <label> Giới tính(<span style="color:red">*</span>)</label><br>
                        <select @if($mode == 'detail') disabled @endif name="" id="" wire:model.defer="sex"
                                class="form-control">
                            <option value="">Chọn giới tính</option>
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                        </select>
                        @error('sex')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal" wire:click="resetValidate()">
                        Đóng
                    </button>
                    <button type="button" @if($mode == 'detail') disabled @endif class="btn btn-primary"
                            wire:click='saveData'>Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.common._modalDelete')
</div>

<script>
    $("document").ready(() => {
        window.livewire.on('closeModalCreateEdit', () => {
            $('#modelCreateEditTicket').modal('hide');
        });
    });
</script>
