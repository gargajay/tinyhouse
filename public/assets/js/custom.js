$("#show_menu").click(function(){
    $("body").addClass("open_menu");
    $(".mobile_menu").addClass("show");
});
$("#close_menu").click(function(){
    $("body").removeClass("open_menu");
    $(".mobile_menu").removeClass("show");
});

$(".show_filter").click(function(){
    $(".search_sec_inner .filter").addClass("show");
});
$(".close_filter").click(function(){
    $(".search_sec_inner .filter").removeClass("show");
});

$('.house_gallery').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: '.house_gallery_thumb'
});
$('.house_gallery_thumb').slick({
    slidesToShow: 10,
    slidesToScroll: 1,
    asNavFor: '.house_gallery',
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
    responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 8,
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 6,
          }
        },
        {
          breakpoint: 575,
          settings: {
            slidesToShow: 5,
          }
        }
    ]
});