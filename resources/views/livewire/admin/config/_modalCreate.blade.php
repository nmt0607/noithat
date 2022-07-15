<!-- Modal Create -->
<form wire:submit.prevent="submit" enctype="multipart/form-data">
        <div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('master/masterManager.form_data.create')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true close-btn">×</span>
                </button>
              </div>
              <div class="modal-body">
              <form>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.vkey')}}<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" name="vkey"wire:model.defer="vkey" placeholder="{{__('master/masterManager.menu_name.master_title_table.vkey')}}">
                        @error('vkey')
                            @include('layouts.partials.text._error')
                        @enderror

                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.vvalue')}}<span class="text-danger"></span></label>
                        <input type="text" class="form-control" name="vvalue" wire:ignore wire:model.defer="vvalue" placeholder="{{__('master/masterManager.menu_name.master_title_table.vvalue')}}">
                        @error('vvalue') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.vvalueen')}}<span class="text-danger"></span></label>
                        <input type="text" class="form-control" wire:ignore wire:model.defer="vvalueen" placeholder="{{__('master/masterManager.menu_name.master_title_table.vvalueen')}}">

                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.ordernumber')}}<span class="text-danger"></span></label>
                        <input type="number" class="form-control" wire:ignore wire:model.defer="ordernumber" placeholder="{{__('master/masterManager.menu_name.master_title_table.ordernumber')}}">
                        @error('ordernumber') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.type')}}<span class="text-danger">(*)</span></label>
                        <select name="type" id="" wire:model.defer="type" class="form-control">
                          <option value="">---Chọn---</option>
                          @foreach($dataType as $key =>$item)
                          <option value="{{$key}}">{{$item}}</option>
                          @endforeach
                        </select>
                        @error('type')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >URL <span class="text-danger"></span></label>
                        <input type="number" class="form-control" wire:ignore wire:model.defer="url" placeholder="URL">

                    </div>
                    <div class="form-group" wire:ignore >
                        <label >{{__('master/masterManager.menu_name.master_title_table.content')}} <span class="text-danger"></span></label>
                        <textarea wire:model.defer="content" id="content" rows="5" cols="100" ></textarea>

                    </div>
                    <div class="form-group" wire:ignore >
                        <label >{{__('master/masterManager.menu_name.master_title_table.content_en')}} <span class="text-danger"></span></label>
                        <textarea  wire:model.defer="content_en" id="content_en" rows="5" cols="100"></textarea>
                    </div>
                    <div class="form-group" wire:ignore >
                        <label >{{__('master/masterManager.menu_name.master_title_table.note')}} <span class="text-danger"></span></label>
                        <textarea class="textarea"  id="note" rows="5" cols="100"></textarea>

                    </div>
                    <div class="form-group" wire:ignore >
                        <label >{{__('master/masterManager.menu_name.master_title_table.note_en')}} <span class="text-danger"></span></label>
                        <textarea class="textarea"  id="note_en" rows="5" cols="100"></textarea>
                    </div>
                    <div class="form-group">
                      <label >Number Value</label>
                      <input type="number" class="form-control"  wire:model.defer="number_value">
                    </div>
                    <div class="form-group">
                      <label >{{__('master/masterManager.menu_name.master_title_table.image')}} <span class="text-danger"></span></label>
                      <input type="file"  id="image" wire:model.defer="image" name="image" rows="5" cols="100">
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" wire:click.prevent="resetform()" id="close-modal-create" class="btn btn-outline-primary close-btn " data-dismiss="modal" >Đóng</button>
                <button type="button" id="btn-save" class="btn btn-primary close-modal">Lưu</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- End Modal Create -->
