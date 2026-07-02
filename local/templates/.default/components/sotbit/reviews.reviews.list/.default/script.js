$(document).ready(function () {
    const firstAjax = $('.tabs-caption #reviews').data('ajax');

    if (firstAjax !== 'Y') {
        const siteDir = $('#idsReviews').attr("data-site-dir");
        const ids = $('#idsReviews').html();
        $.ajax({
            type: 'POST',
            url: siteDir + 'bitrix/components/sotbit/reviews.reviews.list/ajax/shows.php',
            data: {Ids: ids},
            success: function (data) {
            },
            error: function (jqXHR, exception) {
            }
        });
    }

    //Quote
    $(document).on('click', '.reviews-container .quote',
        function () {
            const text = $(this).closest('.reviews-container__body').find('.revirew-body__content').html();

            $(this).closest('.tabs-content').parent().find('.spoiler-reviews-body').show('normal');
            $(this).closest('.tabs-content').parent().find('#review-editor').find('iframe').contents().find('body').append('<blockquote class="bxhtmled-quote">' + text + '</blockquote>');
            $('.add-review').css({'display': 'block'});
            $('html, body').animate({
                scrollTop: $(".add-review").offset().top
            }, 2000);

            return false;
        });

    //Actions
    $(document).on('click', '.reviews-container__ban-user',
        function () {
            const _this = $(this);
            const action = $(this).data('action');
            let r;

            if (action === 'ban') {
                r = confirm($(_this).closest('.ban-menu').find('#ban-confirm-text').html());
            }

            if (r != true) {
                return;
            }

            var ID = $(this).closest('.reviews-container__item').data('id');
            var SiteDir = $(this).closest('.reviews-container__item').data('site-dir');
            $.ajax({
                type: 'POST',
                url: SiteDir + 'bitrix/components/sotbit/reviews.reviews.list/ajax/' + action + '.php',
                data: {ID: ID},
                success: function (data) {
                    var Top = _this.position().top;
                    Top -= 9;
                    var Left = _this.position().left;
                    Left -= 26;
                    if (data.trim() == 'SUCCESS') {

                        console.log('succ')

                        if (action == 'ban') {
                            $(_this).closest('.ban-menu').find('.ban-menu__message-success').css({
                                'top': Top,
                                'left': Left,
                                'z-index': 2
                            });
                            $(_this).closest('.ban-menu').find('.ban-menu__message-success').animate({
                                opacity: 1,
                            }, 500, function () {

                                setTimeout(function () {
                                    $(_this).closest('.ban-menu').find('.ban-menu__message-success').animate({
                                        opacity: 0,
                                    }, 500, function () {
                                        $(_this).closest('.ban-menu').find('.ban-menu__message-success').css({
                                            'top': '25px',
                                            'left': '0',
                                            'z-index': 0
                                        });
                                    });
                                }, 2000);
                            });
                        }
                    } else {
                        if (action == 'ban') {
                            $(_this).closest('.ban-menu').find('.ban-menu__message-error').css({
                                'top': Top,
                                'left': Left,
                                'z-index': 2
                            });
                            $(_this).closest('.ban-menu').find('.ban-menu__message-error').animate({
                                opacity: 1,
                            }, 500, function () {

                                setTimeout(function () {
                                    $(_this).closest('.ban-menu').find('.ban-menu__message-error').animate({
                                        opacity: 0,
                                    }, 500, function () {
                                        $(_this).closest('.ban-menu').find('.ban-menu__message-error').css({
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

    //Нажат Like
    $(document).on('click', '.review-likes__vote_send-yes',
        function () {
            if (!this.closest('.review-likes').querySelector('.review-likes__vote_voted-no')) {
                sendVote(this, 'like', true);
            }
        }
    );

    //Нажат Dislike
    $(document).on('click', '.review-likes__vote_send-no',
        function () {
            if (!this.closest('.review-likes').querySelector('.review-likes__vote_voted-yes')) {
                sendVote(this, 'dislike', true);
            }
        }
    );

    //Нажат Like
    $(document).on('click', '.review-likes__vote_voted-yes',
        function () {
            sendVote(this, 'like', false);
        }
    );

    //Нажат Dislike
    $(document).on('click', '.review-likes__vote_voted-no',
        function () {
            sendVote(this, 'dislike', false);
        }
    );

    function sendVote(element, type, increase) {
        const id = element.parentNode.dataset.reviewId;
        const siteDir = element.parentNode.dataset.siteDir;
        const likesNumberContainer = element.querySelector('.reviews-container__likes-number');
        let likesNumber = parseInt(likesNumberContainer.textContent);
        let action;

        if (!increase) {
            likesNumber -= 2;
        }

        if (type === 'like') {
            if (increase) {
                element.classList.remove('review-likes__vote_send-yes');
                element.classList.add('review-likes__vote_voted-yes');
            } else {
                element.classList.add('review-likes__vote_send-yes');
                element.classList.remove('review-likes__vote_voted-yes');
            }
            action = 'LIKES';
        } else {
            if (increase) {
                element.classList.remove('review-likes__vote_send-no');
                element.classList.add('review-likes__vote_voted-no');
            } else {
                element.classList.add('review-likes__vote_send-no');
                element.classList.remove('review-likes__vote_voted-no');
            }
            action = 'DISLIKES';
        }

        $.ajax({
            type: 'POST',
            url: siteDir + 'bitrix/components/sotbit/reviews.reviews.list/ajax/likes.php',
            data: {action: action, id: id, Likes: likesNumber},
            success: function (data) {
                likesNumberContainer.textContent = (++likesNumber).toString();
            },
            error: function (xhr, str) {
                console.lo(xhr.responseCode);
            }
        });
    }

    $(document).on('click', '#filter-pagination button:not(.current)',
        function () {
            MaxPage = parseInt($("#filter-pagination .last").attr("data-number"));
            CurrentPage = parseInt($(this).attr("data-number"));
            ReloadReviews(CurrentPage);
        });

});

function ReloadReviews(FilterPage) {
    const Url = $(".reviews-filter").data("url"),
        IdElement = $(".reviews-filter").attr("data-id-element"),
        MAX_RATING = $(".reviews-filter").attr("data-max-rating"),
        SiteDir = $(".reviews-filter").attr("data-site-dir"),
        TEMPLATE = $(".reviews-filter").attr("data-template"),
        FilterRating = $("#current-option-select-rating").attr("data-value"),
        FilterImages = $("#filter-images").attr("data-value"),
        FilterSortBy = $("#current-option-select-sort").attr("data-sort-by"),
        FilterSortOrder = $("#current-option-select-sort").attr("data-sort-order"),
        PrimaryColor = $(".reviews-container").attr("data-primary-color"),
        DateFormat = $(".reviews-container").attr("data-date-format");

    BX.showWait();

    $.ajax({
        type: 'POST',
        url: SiteDir + 'bitrix/components/sotbit/reviews.reviews.list/ajax/reload_reviews.php',
        data: {
            IdElement: IdElement,
            MAX_RATING: MAX_RATING,
            TEMPLATE: TEMPLATE,
            FilterRating: FilterRating,
            FilterImages: FilterImages,
            FilterSortOrder: FilterSortOrder,
            FilterSortBy: FilterSortBy,
            FilterPage: FilterPage,
            PrimaryColor: PrimaryColor,
            DateFormat: DateFormat,
            Url: Url
        },
        success: function (data) {
            $('.reviews-container').html(data);
            const SiteDir = $(".reviews-filter").attr("data-site-dir");
            const Ids = $('#idsReviews').html();
            $.ajax({
                type: 'POST',
                url: SiteDir + 'bitrix/components/sotbit/reviews.reviews.list/ajax/shows.php',
                data: {Ids: Ids},
                success: function (data) {
                },
                error: function (jqXHR, exception) {
                }
            });
            BX.closeWait();
        },
        error: function (jqXHR, exception) {
        }
    });
}
