$("document").ready(function(){
    // window.addEventListener('setSelect2', event => {
    //     $(".select2-box1").select2({
    //         width: 'resolve',
    //     });
    // });

    window.livewire.on('closeModalCreateEdit', () => {
        $('#modelCreateEdit').modal('hide');
    });

    $(".select2-box").select2({
        placeholder: "Chọn loại",
        allowClear: true,
    });

    window.livewire.on('setSelect2Input', () => {
        $(".select2-box").select2({
            placeholder: "Chọn loại",
            allowClear: true,
            }
        );
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
});
