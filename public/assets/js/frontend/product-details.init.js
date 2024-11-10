/*
Template Name: Toner eCommerce + Admin HTML Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: product Details init js
*/

var swiper = new Swiper(".productSwiper", {
    
    spaceBetween: 10,
    slidesPerView: 4,
    mousewheel: true,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
      992: {
        slidesPerView: 4,
        spaceBetween: 10,
        direction: "vertical",
      },
    },
  });