$(document).ready(function () {
    //Quote
    $(document).on('click', '.comments_quote',
        function () {
            let visible = !!$(this).closest('.reviews-container__item').find('.spoiler-comments-body').is(':visible');

            $(this).closest('.reviews-container__item').find('.spoiler-comments-body').toggle('normal');
            if (!visible) {
                var text = $(this).closest('.reviews-container__item').find('.revirew-body__content').html();
                var Scroll = $(this).closest('.reviews-container__item').find('.spoiler-comments-body');
                $(this).closest('.reviews-container__item')
                    .find('.spoiler-comments-body')
                    .find('#comments-editor')
                    .find('iframe')
                    .contents()
                    .find('body')
                    .append('<blockquote class="bxhtmled-quote">' + text + '</blockquote>');
                $('html, body').animate({
                    scrollTop: Scroll.offset().top
                }, 500);
            } else {
                $(this).closest('.reviews-container__item')
                    .find('.spoiler-comments-body')
                    .find('#comments-editor')
                    .find('iframe')
                    .contents()
                    .find('body')
                    .text('');
            }
            return false;
        }
    );

    $(document).on('click', '.add-comments__send-answer-btns .main_btn.reset',
        function () {
            $(this).closest('.spoiler-comments-body').toggle('normal');
        }
    );
});
