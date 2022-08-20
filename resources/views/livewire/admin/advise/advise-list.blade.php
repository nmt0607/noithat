<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Danh sách đăng ký nhận tư vấn
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Danh sách đăng ký nhận tư vấn</div>
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
                            <input wire:model.debounce.1000ms="searchName" placeholder="Tìm kiếm theo tên, số điện thoại, email" type="text" class="form-control">
                        </div>
                        <div class="col-4" >
                            <label class="col-form-label">Địa chỉ IP</label>
                            <input wire:model.debounce.1000ms="searchIp" placeholder="Tìm kiếm theo địa chỉ IP" type="text" class="form-control">
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <button type="button" class="btn btn-outline-primary" wire:click="resetSearch()"><i class="fa fa-undo"></i> Làm mới</button>
            </div>

            <div wire:loading class="loader"></div>
            <table class="table table-bordered table-hover dataTable dtr-inline" role="grid" aria-describedby="example2_info">
                <thead>
                    <tr role='row'>
                        <th class='text-center w-60'>STT</th>
                        <th>Họ và tên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Chức vụ</th>
                        <th>Mã số thuế</th>
                        <th>IP người dùng</th>
                        <th>Thời gian gửi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $key => $row)
                        <tr>
                            <td class='text-center'>{{($data->currentPage() - 1) * $data->perPage() + $loop->iteration}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->phone}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->position}}</td>
                            <td>{{$row->tax_code}}</td>
                            <td>{{$row->IP}}</td>
                            <td>{{reFormatDate($row->created_at,'Y-m-d H:i:s')}}</td>
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
    @include('livewire.common._modalDelete')
</div>

<script>
    $("document").ready(() => {
    });
</script>
