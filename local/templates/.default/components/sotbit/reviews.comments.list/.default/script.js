$(document).ready(function () {

    var FirstAjax = $('.tabs-caption #comments').data('ajax');

    if (FirstAjax !== 'Y') {
        var SiteDir = $('#idsComments').attr("data-site-dir");
        var Ids = $('#idsComments').html();
        $.ajax({
            type: 'POST',
            url: SiteDir + 'bitrix/components/sotbit/reviews.comments.list/ajax/shows.php',
            data: {Ids: Ids},
            success: function (data) {
            },
            error: function (jqXHR, exception) {
            }
        });
    }

    let answerBtns = document.querySelectorAll('.spoiler-input.answer');
    answerBtns.forEach(
        function(btn) {
            btn.addEventListener(
                'click',
                function () {
                    this.closest('.reviews-body').querySelector('.spoiler-comments-body').style.display = 'block';
                    return false;
                }
            );
        }
    );

    //Actions
    $(document).on('click', '#comments-body .actions',
        function () {
            $(this).closest('.menu').toggleClass('open');
        });
    $(document).on('click', '#comments-body .menu ul li',
        function () {

            var _this = $(this);
            var Action = $(this).data('action');
            if (Action == 'ban')
                var r = confirm($(_this).closest('.menu').find('#ban-confirm-text').html());

            if (r != true)
                return;
            var ID = $(this).closest('.item').data('id');
            var SiteDir = $(this).closest('.item').data('site-dir');
            $.ajax({
                type: 'POST',
                url: SiteDir + 'bitrix/components/sotbit/reviews.comments.list/ajax/' + Action + '.php',
                data: {ID: ID},
                success: function (data) {
                    var Top = _this.position().top;
                    Top -= 9;
                    var Left = _this.position().left;
                    Left -= 26;
                    if (data.trim() == 'SUCCESS') {

                        if (Action == 'ban') {
                            $(_this).closest('.menu').find('.ban-message-success').css({
                                'top': Top,
                                'left': Left,
                                'z-index': 2
                            });
                            $(_this).closest('.menu').find('.ban-message-success').animate({
                                opacity: 1,
                            }, 500, function () {

                                setTimeout(function () {
                                    $(_this).closest('.menu').find('.ban-message-success').animate({
                                        opacity: 0,
                                    }, 500, function () {
                                        $(_this).closest('.menu').find('.ban-message-success').css({
                                            'top': '25px',
                                            'left': '0',
                                            'z-index': 0
                                        });
                                    });
                                }, 2000);
                            });
                        }
                    } else {
                        if (Action == 'ban') {
                            $(_this).closest('.menu').find('.ban-message-error').css({
                                'top': Top,
                                'left': Left,
                                'z-index': 2
                            });
                            $(_this).closest('.menu').find('.ban-message-error').animate({
                                opacity: 1,
                            }, 500, function () {

                                setTimeout(function () {
                                    $(_this).closest('.menu').find('.ban-message-error').animate({
                                        opacity: 0,
                                    }, 500, function () {
                                        $(_this).closest('.menu').find('.ban-message-error').css({
                                            'top': '25px',
                                            'left': '0',
                                            'z-index': 0
                                        });
                                    });
                                }, 1000);
                            });
                        }
                    }
                },
                error: function (xhr, str) {
                    alert(xhr.responseCode);
                }
            });
        });
    $(document).on('click', '#filter-pagination-comments button:not(.current)',
        function () {
            // MaxPage = parseInt($("#filter-pagination-comments .last").attr("data-number"));
            const currentPage = parseInt($(this).attr("data-number"));
            ReloadComments(currentPage);
        });

});

function ReloadComments(FilterPage) {
    const url = $("#filter-pagination-comments").data("url");
    const idElement = $("#filter-pagination-comments").attr("data-id-element");
    const SiteDir = $("#filter-pagination-comments").attr("data-site-dir");
    const template = $("#filter-pagination-comments").attr("data-template");
    const primaryColor = $("#filter-pagination-comments").attr("data-primary-color");
    const dateFormat = $("#filter-pagination-comments").attr("data-date-format");

    BX.showWait();
    $.ajax({
        type: 'POST',
        url: SiteDir + 'bitrix/components/sotbit/reviews.comments.list/ajax/reload_comments.php',
        data: {
            IdElement: idElement,
            TEMPLATE: template,
            FilterPage: FilterPage,
            PrimaryColor: primaryColor,
            DateFormat: dateFormat,
            Url: url
        },
        success: function (data) {
            $('#comments-list').html(data);
            BX.closeWait();
        },
        error: function (jqXHR, exception) {
        }
    });
}
