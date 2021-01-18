if(parent){
    $(function(){    
        var iframe = parent.document.querySelector('#swal_popup');
        var height = $('.new_win').height();
        $(iframe).css('height', height + "px");
        document.body.classList.remove('bg-gray-100');
    });
}
function popup_close(){
    $(parent.document).find('.swal2-container').trigger('click');
}