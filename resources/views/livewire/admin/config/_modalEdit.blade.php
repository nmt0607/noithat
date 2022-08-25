<!-- Modal Create -->
<form wire:submit.prevent="submit">
        <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa cấu hình</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true close-btn">×</span>
                </button>
              </div>
              <div class="modal-body">
              <form>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.vkey')}}<span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" name="vkey"  wire:model.defer="vkey" placeholder="{{__('master/masterManager.menu_name.master_title_table.vkey')}}">
                        @error('vkey')
                            @include('layouts.partials.text._error')
                        @enderror

                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.vvalue')}}<span class="text-danger"></span></label>
                        <input type="text" class="form-control" name="vvalue" wire:model.defer="vvalue" placeholder="{{__('master/masterManager.menu_name.master_title_table.vvalue')}}">
                        @error('vvalue') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.vvalueen')}}<span class="text-danger"></span></label>
                        <input type="text" class="form-control"  wire:model.defer="vvalueen" placeholder="{{__('master/masterManager.menu_name.master_title_table.vvalueen')}}">

                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.ordernumber')}}<span class="text-danger"></span></label>
                        <input type="number" class="form-control" wire:model.defer="ordernumber" placeholder="{{__('master/masterManager.menu_name.master_title_table.ordernumber')}}">
                        @error('ordernumber') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label >{{__('master/masterManager.menu_name.master_title_table.type')}}<span class="text-danger">(*)</span></label>
                        {{-- <input type="number" class="form-control"  wire:model.defer="type" placeholder="{{__('master/masterManager.menu_name.master_title_table.type')}}"> --}}
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
                        <input type="text" class="form-control"  wire:model.defer="url" placeholder="URL">

                    </div>
                    <div class="form-group" wire:ignore>
                        <label >{{__('master/masterManager.menu_name.master_title_table.content')}} <span class="text-danger"></span></label>
                        <textarea  wire:model.defer="content" id="content_edit" rows="5" cols="100"></textarea>

                    </div>
                    <div class="form-group" wire:ignore>
                        <label >{{__('master/masterManager.menu_name.master_title_table.content_en')}} <span class="text-danger"></span></label>
                        <textarea  wire:model.defer="content_en" id="content_en_edit" rows="5" cols="100"></textarea>
                    </div>
                    <div class="form-group" wire:ignore>
                        <label >{{__('master/masterManager.menu_name.master_title_table.note')}} <span class="text-danger"></span></label>
                        <textarea class="textarea" id="note_edit" rows="5" cols="100" wire:model.defer="note"></textarea>

                    </div>
                    <div class="form-group" wire:ignore>
                        <label >{{__('master/masterManager.menu_name.master_title_table.note_en')}} <span class="text-danger"></span></label>
                        <textarea class="textarea" id="note_en_edit" rows="5" cols="100" wire:model.defer="note_en"></textarea>
                    </div>
                    <div class="form-group">
                        <label >Number Value</label>
                        <input type="number" class="form-control"  wire:model.defer="number_value">
                      </div>
                    <div class="form-group">
                      <label >{{__('master/masterManager.menu_name.master_title_table.image')}} <span class="text-danger"></span></label>
                      <input type="file" id="image_edit" wire:model="image" name="image" rows="5" cols="100" wire:click="$emit('remove_path')">
                    </div>
                    <div class="preview-file">
                        @if($image)
                            <div class="form_content ml-2 form-group preview-data" data="{{ './storage/'. $image }}">
                                <div class="py-2 px-3 bg-light d-flex align-items-center" id="preview-item">
                                    <a href='{{$change_image?"javascript:;":(Storage::disk("s3")->url($image))}}' {{$change_image?"":'target="_blank"'}} style='{{$change_image?"cursor: auto;":""}}'>
                                        <i class="fas fa-file mr-2"></i> {{$image}}
                                    </a>
                                    <div class="border-left ml-2 px-2 btn btn-md" id="removeFile" wire:click="$emit('remove_path')">
                                        <i class="fa fa-times mr-1"></i> Xóa
                                    </div>
                                </div>
                            </div>
                        @endif
                  </div>
                  <input class="form-control" type="hidden" name="remove_path" id="remove_path"/>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" wire:click.prevent="resetform()" id="close-modal-edit" class="btn btn-outline-primary close-btn" data-dismiss="modal" >Đóng</button>
                <button type="button" id="btn-update" class="btn btn-primary close-modal" wire:loading.attr="disabled">Lưu</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- End Modal Create -->
      <script>
        $(function(){
            $(document).on('click', '#removeFile', function(){
                var x = $(this)
                    parent = x.parents(".preview-data")
                    path = parent.attr('data')
                //     i = parent.parent().next();
                // if(path){
                //     i.val(path);
                // }
                // parent.parent().empty();
                // $("input[name='image']").val('');
            });

            $("input[name='image']").change(function(e){
                var f = this.files;
                if(f.length){
                    f = f[0];
                    $("#removeFile").trigger("click");
                    // $(".preview-file").empty().html(
                    //     '<div class="form_content ml-2 form-group preview-data">'
                    //         +'<div class="py-2 px-3 bg-light d-flex align-items-center" id="preview-item">'
                    //             +'<div>'
                    //                 +'<i class="fas fa-file mr-2"></i>' + f.name
                    //             +'</div>'
                    //             +'<div class="border-left ml-2 px-2 btn btn-md" id="removeFile">'
                    //                 +'<i class="fa fa-times mr-1"></i> Xóa'
                    //             +'</div>'
                    //         +'</div>'
                    //     +'</div>'
                    // );
                }
            });

        });
    </script>
