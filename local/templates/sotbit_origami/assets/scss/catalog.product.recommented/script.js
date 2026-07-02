// ----- owl recommended-poducts slider ----//
function CaruselRecommendedProducts() {
    $('.recommended-poducts__slider').owlCarousel({
        // stopOnHover: true,
        loop:true, //Зацикливаем слайдер
        items:5, // один слайд
        nav:true, //Отключение навигации
        navText : ["",""], // Текст навигации
        autoplay:false, //Автозапуск слайдера
        smartSpeed:500, //Время движения слайда
        stagePadding: 10,

        responsive:{ //Адаптивность. Кол-во выводимых элементов при определенной ширине.
            0:{
                items:1
            },
            460:{
                items:2
            },
            810:{
                items:3
            },
            1080:{
                items:4
            },
            1350:{
                items:5
            }
        },
        onInitialized: opacityAdd,
        onResized: opacityAdd,
        onTranslate: opacityReset,
        onTranslated: opacityAdd,
        onDrag: opacityReset
    });

    function opacityAdd () {
        $('.recommended-poducts').find('.owl-item').css('opacity', '1');
        var activeSlides = $('.recommended-poducts').find('.owl-item.active');
        activeSlides.eq(0).prev().css('opacity', '0');
        activeSlides.eq(activeSlides.length - 1).next().css('opacity', '0');

    }
    function opacityReset () {
        $('.recommended-poducts').find('.owl-item').css('opacity', '1');
    }
}

// ----- owl end recommended-poducts slider ----//