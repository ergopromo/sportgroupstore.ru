$(document).ready(function () {

    $(document).on('click', '.reviews-share .share_link', function () {
        var title = $('.reviews-share').find('.share_link').html();
        var text = $(this).data('url');
        $('body').append('<div class="reviews-sharelink-popup" id="reviews-sharelink-popup">' +
            '<p class="modal-title">' + title + '</p><span id="modal_close"></span><div class="reviews-sharelink-input-container">' +
            '<input class="text reviews-sharelink-text" value="' + text + '">' +
            '<button class="copy-in-buffer">' +
            '<svg class="icon_copy_link" width="16" height="16">\n' +
            '<use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_copy_link"></use>\n' +
            '</svg>' +
            '</button>' +
            '</div></div>' +
            '<div  id="reviews-sharelink-overlay"></div>');

        function copyTextInBuffer() {
            const copyText = document.querySelector(".reviews-sharelink-text");
            copyText.select();
            document.execCommand("copy");
        }

        if (document.querySelector('.copy-in-buffer')) {
            document.querySelector('.copy-in-buffer').addEventListener('click', copyTextInBuffer);
        }

        $('#reviews-sharelink-overlay').fadeIn(400,
            function () {
                var html = document.documentElement;
                var w = $('#reviews-sharelink-popup').outerWidth(true);
                var h = parseInt($('#reviews-sharelink-popup').outerHeight(true));
                var left = (html.clientWidth / 2) - (w / 2);
                var top = (html.clientHeight / 2) - (h / 2);

                $('#reviews-sharelink-popup')
                    .css('display', 'block')
                    .animate({opacity: 1, top: top, left: left}, 200);
            });
    });
    $(document).on('click', '#reviews-sharelink-popup #modal_close, #reviews-sharelink-overlay', function () {
        $('#reviews-sharelink-popup')
            .animate({opacity: 0, top: '45%'}, 200,
                function () {
                    $(this).css('display', 'none');
                    $('#reviews-sharelink-overlay').fadeOut(400, function () {
                        $("#reviews-sharelink-overlay").remove();
                        $("#reviews-sharelink-popup").remove();
                    });
                });
    });
});

