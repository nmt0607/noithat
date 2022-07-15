<div class="body-content p-2">
    <div class="card">
        <div class="card-body p-2">
            <div class="row d-flex">
                <h4 class='ml-2'>Quản lý thông tin</h4>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-5">
                        <label>Tên người dùng (<span style='color:red;'>*</span>)</label>
                        <input type="text" class='form-control' placeholder='Tên người dùng' wire:model.defer='name'>
                        @error('name')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="offset-1 col-5">
                        <label>Số điện thoại (<span style='color:red;'>*</span>)</label>
                        <input type="text" class='form-control' placeholder='Số điện thoại' wire:model.defer='phone'>
                        @error('phone')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                </div>  
                <div class="row mt-2">
                    <div class="col-5">
                        <label>Email (<span style='color:red;'>*</span>)</label>
                        <input type="text" class='form-control' placeholder='Email' wire:model.defer='email'>
                        @error('email')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class="offset-1 col-5">
                        <label>Ngày sinh (<span style='color:red;'>*</span>)</label>
                        <input type="date" class='form-control' placeholder='Ngày sinh' wire:model.defer='date'>
                        @error('date')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                </div> 
                <div class="row mt-2">
                    <div class="col-5">
                        <label>Giới tính</label>
                        <select wire:model.defer='sex' class='form-control custom-select'>
                            <option value="">---Chọn giới tính---</option>
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                        </select>
                        @error('sex')
                            @include('layouts.partials.text._error')
                        @enderror
                    </div>
                </div>  
                <div class="row mt-2">
                    <div class="col-2">
                        <label>Ảnh đại diện</label>
                        <br>
                        <button type="button" class="btn btn-outline-primary" id='btn-upload-image'>Tải ảnh lên</button>
                        <div style='width:88px;'>
                            <div id='file-loading' class="file-loading bg-primary rounded text-center text-white" style="transition: width 0.3s; bottom: 0px; left: 0; height: 5px; width: 0%;">&nbsp;</div>
                        </div>
                        <input type="file" id='image' name='image' accept='image/*' style='display:none;' onchange="uploadFile(this, @this)">
                        <br>
                        @error('file')
                        @include('layouts.partials.text._error')
                        @enderror
                    </div>
                    <div class='col-10'>
                        <img  style='border-radius:50%;' width='200px' class='mt-2 ml-1' src='{{$file?$file->temporaryUrl():($image?$image:asset("images/users/user_dafault.jpg"))}}'/>
                    </div>
                </div>  
                <div class="row mt-4">
                    <button type="button" class="btn btn-primary" wire:click='saveData'>
                        Lưu thay đổi 
                    </button>
                    <button class="btn btn-danger ml-2" wire:click='resetData'>
                        Hoàn tác
                    </button>
                </div>  
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="row d-flex">
                <h4>Quản lý mật khẩu</h4>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="">Mật khẩu hiện tại (<span style='color:red;'>*</span>)</label>
                    <input type="password" placeholder='Mật khẩu hiện tại' id='currentPassword' class='form-control' readonly="" onfocus="this.removeAttribute('readonly');" wire:ignore>
                    @error('currentPassword')
                        @include('layouts.partials.text._error')
                    @enderror
                </div>
                <div class="row mt-2">
                    <label for="">Mật khẩu mới (<span style='color:red;'>*</span>)</label>
                    <input type="password" placeholder='Mật khẩu mới' id='newPassword' class='form-control' readonly="" onfocus="this.removeAttribute('readonly');" wire:ignore>
                    @error('newPassword')
                        @include('layouts.partials.text._error')
                    @enderror
                </div>
                <div class="row mt-2">
                    <label for="">Nhập lại mật khẩu mới (<span style='color:red;'>*</span>)</label>
                    <input type="password" placeholder='Nhập lại mật khẩu mới' id='confirmPassword'  class='form-control' readonly="" onfocus="this.removeAttribute('readonly');" wire:ignore>
                    @error('confirmPassword')
                        @include('layouts.partials.text._error')
                    @enderror
                </div>
                <div class="row mt-4">
                    <button type="button" class="btn btn-primary" id='btn-change-password'>Lưu thay đổi</button>
                </div>  
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Đổi mật khẩu</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label for="">Mật khẩu hiện tại (<span style='color:red;'>*</span>)</label>
                            <input type="password" placeholder='Mật khẩu hiện tại' id='currentPassword' class='form-control' readonly="" onfocus="this.removeAttribute('readonly');" wire:ignore>
                            @error('currentPassword')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>
                        <div class="row mt-2">
                            <label for="">Mật khẩu mới (<span style='color:red;'>*</span>)</label>
                            <input type="password" placeholder='Mật khẩu mới' id='newPassword' class='form-control' readonly="" onfocus="this.removeAttribute('readonly');" wire:ignore>
                            @error('newPassword')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>
                        <div class="row mt-2">
                            <label for="">Nhập lại mật khẩu mới (<span style='color:red;'>*</span>)</label>
                            <input type="password" placeholder='Nhập lại mật khẩu mới' id='confirmPassword'  class='form-control' readonly="" onfocus="this.removeAttribute('readonly');" wire:ignore>
                            @error('confirmPassword')
                                @include('layouts.partials.text._error')
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
                    <button type="button" class="btn btn-primary" id='btn-change-password'>Đồng ý</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var loadFile = function(event) {
        var output = document.getElementById('previewImage');
        if(event.target.files[0]){
            $('#previewImage').css('display', 'block');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
        else {
            $('#previewImage').css('display', 'none');
        }
    }; 
    $("document").ready(() => {
        $('#btn-upload-image').click(function(){
            $('#image').click()
        })
        window.livewire.on('closeModalCreateEdit', () => {
            $('#modelCreateEditTicket').modal('hide');
        });
        $('.select2').on('change', function (e) {
            let data = $(this).val();
            @this.set('selectedUserGroups', data);
        });
        $('.select2').select2({
            placeholder: 'Chọn nhóm người dùng'
        });
        window.livewire.on('set-user-groups', () => {
            $('.select2').select2({
                placeholder: 'Chọn nhóm người dùng'
            });
        });
        window.livewire.on('setData', (name,image) => {
            $('#userName').text(name)
            $('#userImage').attr("src",image);
        });
        $('#btn-change-password').click(function(){
            // alert('vào');
            @this.emit('changePassword',{
                currentPassword : $('#currentPassword').val(),
                newPassword : $('#newPassword').val(),
                confirmPassword :  $('#confirmPassword').val(),
            })
        })
        window.livewire.on('resetData', () => {
            $('#currentPassword').val('')
            $('#newPassword').val('')
            $('#confirmPassword').val('')
            // $('#modalChangePassword').modal('toggle');
        });
    });

    function uploadFile(input, proxy = null, index = 0) {

        let file = input.files[index];
        if (!file || !proxy) return;
        let $fileLoading = $('#file-loading');
        $fileLoading.width('0%');
  
        proxy.upload('file', file, (uploadedFilename) => {
            setTimeout(() => {
                $fileLoading.width('0%');
                uploadFile(input, proxy, index + 1);
            }, 500);
        }, () => {
            console.log(error);
        }, (event) => {
            $fileLoading.width(event.detail.progress + '%');
        });
    }
</script>