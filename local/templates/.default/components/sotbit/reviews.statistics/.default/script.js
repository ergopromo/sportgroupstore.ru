$(document).on('click', '.product-rating__write-review',
    function () {
        if (document.querySelector('.add-reviews .add-review')) {
            $('.add-reviews').find('.add-review').toggle('normal');
        } else if (document.querySelector('.register_area')) {
            $('.register_area').toggle('normal');
        }
        return false;
    }
);
