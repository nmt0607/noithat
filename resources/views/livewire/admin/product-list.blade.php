<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Quản lý sản phẩm
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Quản lý sản phẩm</div>
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
                            <input wire:model.debounce.1000ms="searchName" placeholder="Nhập tên sản phẩm" type="text" class="form-control">
                        </div>
                        <div class="col-3" >
                            <label class="col-form-label">Danh mục sản phẩm</label>
                            <select class='form-control' wire:model='searchTypeLv1'>
                                <option value="">Tất cả</option>
                                @foreach($pdTypeParentListLv1 as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3" >
                            <label class="col-form-label">Thuộc phòng</label>
                            <select class='form-control' wire:model='searchType'>
                                <option value="">Tất cả</option>
                                @foreach($pdTypeParentList as $key => $value)
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
                        <a href="{{route('admin.product.create')}}">
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
                        <th>Tên sản phẩm</th>
                        <th>Mã sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Thuộc phòng</th>
                        <th>Tình trạng</th>
                        <th>Bảo hành</th>
                        <th>Giá tiền</th>
                        <th class='text-center'>Ảnh đại diện</th>
                        <th class='text-center w-120'>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <td class='text-center'>{{($data->currentPage() - 1) * $data->perPage() + $loop->iteration}}</td>
                            <td>{{strlen($row['name']) > 80 ? mb_substr($row['name'], 0, 80, 'UTF-8') . '...' : $row['name']}}</td>
                            <td>{{strlen($row['code']) > 80 ? mb_substr($row['code'], 0, 80, 'UTF-8') . '...' : $row['code']}}</td>
                            <td>{{$row->productType->name??''}}</td>
                            <td>{{$row->productType->parent->name??''}}</td>
                            <td>{{$row['status']}}</td>
                            <td>{{$row['guarantee']}}</td>
                            <td>{{$row['price']}}</td>
                            <td class='text-center'>
                                @if($row->avatar)
                                <img src="{{asset($row->avatar->path)}}" class="job-logo-ima" alt="job-logo" width="70px" height="70px">
                                @else
                                No image
                                @endif
                            </td>
                            <td class='text-center'>
                                <a  href="{{route('admin.product.edit',$row['id'])}}" class='btn btn-primary btn-sm' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
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
    @include('livewire.common._modalDelete')
</div>

<script>
    $("document").ready(() => {
    });
</script>
