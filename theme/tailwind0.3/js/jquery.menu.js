$(function(){
    $('.menu_sub').click(function (e) { 
        e.preventDefault();
        $(this).parent().parent().find('ul.hidden').slideToggle(300);
        //$(this).find('li.hidden').fade(300);
    });
    $('.mobile_menu_sub').click(function (e) { 
        e.preventDefault();
        $(this.parentNode.parentNode).find('ul.hidden').toggleClass('fixed mb-16');
        $(this.parentNode.parentNode).find('ul.hidden').toggle();
        console.log(menu);
    });
});