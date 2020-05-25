$( document ).ready(function() {

    $('.c2-nav, .qg, .ar, .bi').on({
        mouseenter: function () {
            $('.qg, .ar, .bi').css("display", "block")
        },
        mouseleave: function () {
            $('.qg, .ar, .bi').css("display", "none")
        }
    })
});
