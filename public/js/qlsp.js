
$("document").ready(function () {
    window.addEventListener('setSelect2', event => {
        $(".select_box_province").select2({
            dropdownParent: $('#modelCreateEdit')
        });
        $(".select_box_district").select2({
            dropdownParent: $('#modelCreateEdit')
        });
    });
    window.addEventListener('setSelect2Orders', event => {
        $(".select-box-customer").select2();
        $(".select-box-customer").select2();
    });
    window.addEventListener('setSelect2Warehouse', event => {
        $(".select-box-customer").select2({
            dropdownParent: $('#modelCreateEdit')
        });
    });
    $('.select_box').select2()
    $('.div-hover').hover(function(){
		var elementA = $(this).children()[0];
		$(elementA).css('background-color','#f46a6a')
	})

	$('.div-hover').mouseleave(function(){
		var elementA = $(this).children()[0];
		$(elementA).css('background-color','white')
	})
});





