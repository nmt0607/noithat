<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Quản lý Files
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Quản lý Files</div>
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
                            <input wire:model.debounce.1000ms="searchName" placeholder="Tìm kiếm theo người đăng, model name, tên file" type="text" class="form-control">
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <button type="button" class="btn btn-outline-primary" wire:click="resetSearch"><i class="fa fa-undo"></i> Làm mới</button>
            </div>

            <div wire:loading class="loader"></div>
            <table class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                <thead>
                    <tr role='row'>
                        <th class='text-center w-60'>STT</th>
                        <th>Model ID</th>
                        <th>Tên Model</th>
                        <th>Tên file</th>
                        <th>Dung lượng</th>
                        <th>Ghi chú</th>
                        <th>Người đăng</th>
                        <th class='text-center w-120'>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <td class='text-center'>{{($data->currentPage() - 1) * $data->perPage() + $loop->iteration}}</td>
                            <td>{{$row->model_id}}</td>
                            <td>{{$row->model_name}}</td>
                            <td><a href="{{ Storage::disk('s3')->url($row->url)}}" target="_blank">{{$row->file_name}}</a></td>
                            <td>{{$row->size_file}}</td>
                            <td>{{$row->note}}</td>
                            <td>{{$row->user_name}}</td>
                            <td class='text-center'>
                                <a  href="{{route('admin.files.edit',$row['id'])}}" class='btn btn-primary btn-sm' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
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
</div>

<script>
    $("document").ready(() => {
    });
</script>