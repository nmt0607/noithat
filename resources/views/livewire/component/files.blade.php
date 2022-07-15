<div class="mb-3 upload-container">
    @if($displayUploadfile)
        <div class="file-upload position-relative d-flex justify-content-center align-items-center bg-light py-2 mb-0 border border-light {{ count($files) > 0 ? 'rounded-top' : 'rounded' }}">
            @if ($canUpload && !$disabled)
                <div class="file-input" style="cursor: pointer" onclick="this.children[0].click()">
                    <input type="file" onchange="uploadFile(this, @this)" class="custom-file-input cur_input d-none" multiple>
                    <span wire:loading.class="text-muted" class="file">
                        {{ $name }}
                        <img src="/images/Clip.svg" alt="" height="24">
                    </span>
                </div>
                <div class="file-loading position-absolute bg-primary rounded text-center text-white" style="transition: width 0.3s; bottom: 0px; left: 0; height: 10%; width: 0%;">&nbsp;</div>
            @else
                <span class="file">
                    {{ $name }} ({{ count($files) }})
                    <img src="/images/Clip.svg" alt="" height="24">
                </span>
            @endif
        </div>
    @endif
    <div class="{{ count($files) > 0 ? 'border border-light border-top-0 p-3 rounded-bottom bg-white' : '' }} file-list">
        @foreach ($files as $id => $val)
            @if($displayFile)
            <div class="d-inline-flex mr-2 mb-2 p-2 bg-light align-items-center rounded">
                <img src="/images/File.svg" alt="file" width="50px">
                <div>
                    <a href="{{ $canDownload ? asset('storage/' . $val['url']) : '#' }}" download>
                        <span class="d-block mb-0" style="word-break: break-all;">{{ strLimit($val['file_name']) }}</span>
                        <small class="kb">{{ $val['size_file'] }}</small>
                    </a>
                </div>
                @if ($canUpload && !$disabled)
                    <button wire:click.prevent="deleteFile({{ $id }})" class="btn text-muted">
                        <em class="fa fa-times"></em>
                    </button>
                @endif
            </div>
            @endif
        @endforeach
    </div>
    @error('file')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    @error('files')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    <div class="text-danger upload-error"></div>

    <script>
        function uploadFile(input, proxy = null, index = 0) {

            let file = input.files[index];
            if (!file || !proxy) return;
            let $error = $(input).parents('.upload-container').find('.upload-error');
            let $fileUpload = $(input).parents('.file-upload');
            let $fileInput = $(input).parents('.file-input');
            let $fileLoading = $(input).parents('.file-upload').find('.file-loading');
            $fileLoading.width('0%');

            if (file.size / (1024 * 1024) >= proxy.maximumFileSize) {
                $error.html("{{ __('notification.upload.maximum_size', ['value' => $maximumFileSize]) }}");
                return;
            }
            
            let mimes = {!! json_encode($acceptMimeTypes) !!};
            let extension = file.name.split('.').pop();
            if (!mimes.includes(extension)) {
                $error.html("{{ __('notification.upload.mime_type', ['values' => implode(', ', $acceptMimeTypes)]) }}");
                return;
            }

            
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
</div>
