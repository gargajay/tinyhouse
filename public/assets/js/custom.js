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
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 0,
    speed: 3000,
    cssEase: 'linear',
    pauseOnHover: false,
    focusOnSelect: true,
    asNavFor: '.house_gallery_thumb'
});

$('.main-slider .slide').css({
  'transition': 'transform 5s linear',
});

// Centered slide animation
$('.main-slider .slick-center .slide').css({
  'transform': 'scale(1.2)',
});


$('.house_gallery_thumb').slick({
    slidesToShow: 10,
    slidesToScroll: 1,
    asNavFor: '.house_gallery',
    dots: false,
    arrows: false,
    centerMode: false,
    autoplay: false,

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