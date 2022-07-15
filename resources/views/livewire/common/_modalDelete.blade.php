<div wire:ignore.self class="modal fade" id="exampleDelete" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body box-user">
                <button class="btn float-right" data-dismiss="modal"><em class="fa fa-times"></em></button>
                <h4 class="modal-title">Xác nhận xóa</h4>
                Bạn có muốn xóa bản ghi này không?
            </div>
            <div class="group-btn2 text-center pt-24">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Quay lại</button>
                <button type="button" wire:click.prevent="delete()" class="btn btn-save" data-dismiss="modal">Xóa</button>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Xác nhận xóa</h4>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa bản ghi này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click="delete()">Xóa</button>
            </div>
        </div>
    </div>
</div>