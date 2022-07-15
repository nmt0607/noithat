<div>
    <div class="form_title">
        <label>Tên file </label>
        <div class="row">
            <div class="col mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-xs" id="nameViPrepend">
                            vi
                        </span>
                    </div>
                    <input type="text" class="form-control" name="file_name" wire:model.defer="file_name">
                </div>
                @error('file_name')
                    @include('layouts.partials.text._error')
                @enderror
            </div>
            <div class="col mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-xs" id="nameEnPrepend">
                            en
                        </span>
                    </div>
                    <input type="text" class="form-control" name="file_name_en" wire:model.defer="file_name_en">
                </div>
                @error('file_name_en')
                    @include('layouts.partials.text._error')
                @enderror
            </div>
        </div>
    </div>
    <div class="form_content">
        <label>Url</label>
        <div class="form-group">
            <input disabled type="text" class="form-control" name="url" wire:model.defer="url">
        </div>
    </div>
    <div class="form_content">
        <label>Dung lượng</label>
        <div class="form-group">
            <input disabled type="text" class="form-control" name="size_file" wire:model.defer="size_file">
        </div>
    </div>
    <div class="form_title">
        <label>Ghi chú</label>
        <div class="row">
            <div class="col mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-xs" id="introViPrepend">
                            vi
                        </span>
                    </div>
                    <input  type="text" class="form-control" name="note" wire:model.defer="note">
                </div>
                @error('note')
                    @include('layouts.partials.text._error')
                @enderror
            </div>
            <div class="col mb-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-xs" id="introEnPrepend">
                            en
                        </span>
                    </div>
                    <input  type="text" class="form-control" name="note_en" wire:model.defer="note_en">
                </div>
                @error('note_en')
                    @include('layouts.partials.text._error')
                @enderror
            </div>
        </div>
    </div><br><br><br>
    <div class="row">
        <div class="w-100 clearfix my-2 col-7">
            <button type="button" wire:click.prevent="edit" class="float-right btn ml-1 btn-primary">Lưu lại</button>
            <a href="{{route('files.index')}}">
                <button type="button" class="btn btn-secondary float-right mr-1">Hủy</button>
            </a>
        </div>
    </div>
</div>
