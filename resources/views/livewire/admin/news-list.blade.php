<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Quản lý tin tức
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Quản lý tin tức</div>
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
                            <input wire:model.debounce.1000ms="searchName" placeholder="Nhập từ khóa..." type="text" class="form-control">
                        </div>
                        <div class="col-3" >
                            <label class="col-form-label">Danh mục tin tức</label>
                            <select class='form-control' wire:model='searchCategory'>
                                <option value="">Tất cả</option>
                                <option value="1">Kiến thức nhà đẹp</option>
                                <option value="2">Kiến thức tổng hợp</option>
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
                        <a href="{{route('admin.news.create')}}">
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
                        <th>Tiêu đề</th>             
                        <th>Giới thiệu</th>             
                        <th>Danh mục</th>
                        <th>Ngày đăng tin</th>
                        <th class='text-center'>Ảnh đại diện</th>
                        <th class='text-center w-120'>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($newData as $key => $row)
                        <tr>
                            <td class='text-center'>{{($newData->currentPage() - 1) * $newData->perPage() + $loop->iteration}}</td>
                            <td>{{$row->title}}</td>
                            <td>{{$row->intro}}</td>
                            <td>{{$row->categoryName()}}</td>
                            <td>{{$row->created_at}}</td>
                            <td class='text-center'>
                                @if($row->image)
                                    <img src="{{asset($row->image)}}" class="job-logo-ima" alt="job-logo" width="70px" height="70px">
                                @else 
                                    No image
                                @endif
                            </td>
                            <td class='text-center'>
                                <a  href="{{route('admin.news.edit',$row['id'])}}" class='btn btn-primary btn-sm' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
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
        {{ $newData->links() }}
    </div>
    {{-- Start modal --}}
    @include('livewire.common._modalDelete')
</div>

<script>
    $("document").ready(() => {
    });
</script>
