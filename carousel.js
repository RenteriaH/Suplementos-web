$(document).ready(function () {
    const $carousel = $('#myCarousel');
    let currentIndex = 0;
    const items = $carousel.find('.carousel-item');
    const totalItems = items.length;

    // Mostrar el slide actual
    function showSlide(index) {
        items.removeClass('active').eq(index).addClass('active');
        $('.carousel-indicators li').removeClass('active').eq(index).addClass('active');
    }

    // Navegación con flechas (invisibles)
    $('.carousel-control-prev').click(function (e) {
        e.preventDefault();
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        showSlide(currentIndex);
    });

    $('.carousel-control-next').click(function (e) {
        e.preventDefault();
        currentIndex = (currentIndex + 1) % totalItems;
        showSlide(currentIndex);
    });

    // Navegación con indicadores
    $('.carousel-indicators li').click(function () {
        currentIndex = $(this).data('slide-to');
        showSlide(currentIndex);
    });
});