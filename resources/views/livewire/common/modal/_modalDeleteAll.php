<div class="modal fade" id="modal-delete-all" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Xác nhận xóa tất cả</h4>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa tất cả các bản ghi đã được chọn không?
            </div>
            <div class="modal-footer" style="text-align: center;">
                <div style="float: left;">
                    <p class="text-danger" id='modal-p-delete-all-film' style="display: inline-block;"></p>
                </div>
                <div style="float: right;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click='deleteAll()'>Xóa bỏ</button>
                </div>
            </div>
        </div>
    </div>
</div>