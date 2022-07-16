<div class="body-content p-2">
    <div class="p-2 pb-3 d-flex align-items-center justify-content-between">
        <div class="">
            <h4 class="m-0 ml-2">
                Cấu hình SEO
            </h4>
        </div>
        <div class="paginate">
            <div class="d-flex">
                <div class="">
                    <a href="{{ route('home') }}"><i class="fa fa-home"></i> Trang chủ</a>
                </div>
                <span class="px-2">/</span>
                <div class="">
                    <div class="disable">Cấu hình SEO</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="filter d-flex align-items-center justify-content-between mb-2">
                <div class="row">
                    <div class="col">
                        <div class="form-group search-expertise">
                            <div class="search-expertise inline-block">
                                <input type="text" placeholder="Tìm kiếm" name="search"
                                    class="form-control" id='input_vn_name' autocomplete="off" wire:model.debounce.500ms="searchTerm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <table class="table table-bordered table-hover dataTable dtr-inline">
                <thead class="">
                    <tr>
                        <th class='text-center w-60'>STT</th>
                        <th>Tên</th>
                        <th>Alias</th>
                        <th>Meta</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Keywords</th>
                        <th class='text-center w-120'>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td class='text-center'>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{!! boldTextSearch($row->name, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->alias, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->meta, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->title, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->description, $searchTerm) !!}</td>
                            <td>{!! boldTextSearch($row->keywords, $searchTerm) !!}</td>
                            <td class='text-center'>
                                <a  type='button' class='btn btn-primary btn-sm' data-toggle="modal" data-target="#edit-modal" wire:click='edit({{ $row->id }})' title='Sửa'><i class='fa fa-pencil font-14'></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center text-danger">
                            <td colspan="8">Không tìm thấy dữ liệu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(count($data))
            {{ $data->links() }}
        @endif
    </div>
    {{-- start modal--}}
    <div wire:ignore.self class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <label>CẬP NHẬT</label>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Name</label>
                                        <input type="text" id="name" class="form-control" wire:model.lazy="name" placeholder="Name">
                                    </div>
                                    <div class="col">
                                        <label>Alias</label>
                                        <input type="text" class="form-control" wire:model.lazy="alias" placeholder="Alias" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Note</label>
                                        <input type="text" class="form-control" wire:model.lazy="note" placeholder="Note">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Meta</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameViPrepend">
                                                    vi
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="meta" placeholder="Meta (vi)">
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameEnPrepend">
                                                    en
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="meta_en" placeholder="Meta (en)">
                                        </div>
                                    </div>
                                </div>
                                <label>Title</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameViPrepend">
                                                    vi
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="title" placeholder="Title (vi)">
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameEnPrepend">
                                                    en
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="title_en" placeholder="Title (en)">
                                        </div>
                                    </div>
                                </div>
                                <label>Description</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameViPrepend">
                                                    vi
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="description" placeholder="Description (vi)">
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameEnPrepend">
                                                    en
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="description_en" placeholder="Description (en)">
                                        </div>
                                    </div>
                                </div>
                                <label>Keywords</label>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameViPrepend">
                                                    vi
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="keywords" placeholder="Keywords (vi)">
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-xs" id="nameEnPrepend">
                                                    en
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" wire:model.lazy="keywords_en" placeholder="Keywords (en)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal-edit" class="btn btn-outline-primary close-btn" data-dismiss="modal">Đóng</button>
                    <button type="button" wire:click="update" class="btn btn-primary close-modal">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    {{--end modal--}}
</div>

<script>
    window.livewire.on('close-modal-edit', () => {
        $('#close-modal-edit').click();
    });
</script>