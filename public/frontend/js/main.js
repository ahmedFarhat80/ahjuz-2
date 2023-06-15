$('#owl2').owlCarousel({
    loop: true,
    margin: 24,
    stagePadding: 50,
    nav: false,
    rtl: true,
    autoplay: true,
    dots: false,
    autoplayTimeout: 3000,
    responsive: {
        0: {
            items: 1,
            stagePadding: 16
        },
        600: {
            items: 3,
            stagePadding: 20
        },
        1000: {
            items: 5
        }
    }
})

$('#owl1').owlCarousel({
    loop: true,
    margin: 30,
    nav: false,
    dots: false,
    rtl: true,
    autoplay: true,
    autoplayTimeout: 3000,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 3
        }
    }
})