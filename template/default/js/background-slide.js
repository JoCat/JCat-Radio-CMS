let i = 1;
const images = [
    "url(/template/default/images/1.jpg) 50% 20% / cover no-repeat",
    "url(/template/default/images/2.jpg) 50% 20% / cover no-repeat",
    "url(/template/default/images/3.jpg) 50% 35% / cover no-repeat",
    "url(/template/default/images/4.jpg) 50% 25% / cover no-repeat",
    "url(/template/default/images/5.jpg) 50% 15% / cover no-repeat",
    "url(/template/default/images/6.jpg) 50% 45% / cover no-repeat",
    "url(/template/default/images/7.jpg) 50% 20% / cover no-repeat",
    "url(/template/default/images/8.jpg) 50% 20% / cover no-repeat",
    "url(/template/default/images/9.jpg) 50% 25% / cover no-repeat",
    "url(/template/default/images/10.jpg) 50% 15% / cover no-repeat",
    "url(/template/default/images/11.jpg) 50% 30% / cover no-repeat",
];
function BGSlide() {
    if (i > images.length - 1) {
        i = 0;
        return BGSlide();
    }

    $(".placeholder .background").css("opacity", 0);
    setTimeout(() => {
        $(".placeholder .background").css("background", images[i]);
        $(".placeholder .background").css("opacity", 1);
        i++;
    }, 1000);
}
const intervalBGSlide = setInterval(BGSlide, 15000);
