var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        slidesPerView: 6,
        freeMode: true,
        watchSlidesProgress: true,
});

var swiperOption = {
    spaceBetween: 10,
    loop: true,
    pagination: {
        el: ".swiper-pagination",
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },

};
if($('.mySwiper2').length > 0){
    swiperOption['thumbs'] = {
        swiper: swiper2,
    };
}


var swiper = new Swiper(".mySwiper", swiperOption);

function checkPhone(phone){
    if(!(/^1\d{10}$/.test(phone))){
        return false;
    }
    return true;
}