$(document).ready(function () {
    //Подсчет количества символов в тексте
    $(document).on('keyup', '#add_comment  #contentbox', function () {
        const MaxInput = $(this).attr('maxlength');
        const box = $(this).val();
        if (box.length <= MaxInput) {
            $(this).siblings('.count').children('.count-now').html(box.length);
        }
    });

    //Спойлер
    $(document).on('click', '.spoiler', function () {
            if (document.querySelector('.reviews-container__item .spoiler-comments-body')) {
                $(this).closest('.reviews-container__item').find('.spoiler-comments-body').toggle('normal');
            } else if (document.querySelector('.register_area')) {
                $('.register_area').toggle('normal');
                $('html, body').animate({
                    scrollTop: $(".register_area").offset().top - 60
                }, 2000);
            }
        }
    );

    $(document).on('click', '.spoiler__comments', function () {
            if (document.querySelector('.reviews-container__item .spoiler-comments-body')) {
                $(this).closest('.reviews-container__item').find('.spoiler-comments-body').toggle('normal');
            }
            if (document.querySelector('.add-comments__btn .spoiler__comments .main_btn')) {
                $(this).closest('.add-comments.add-comments__btn').find('.spoiler-comments-body').toggle('normal');
            }
        }
    );

    $(document).on('click', '.comment_cancel', function () {
            $(this).closest('.spoiler-comments-body').toggle('normal');
        }
    );


    $(document).on('click', "#add_comment  #reset-form", function () {
        $(this).closest('#add_comment').find('iframe').contents().find('body').empty();
        $(this).siblings('.count').children('.count-now').html(0);
        $(this).closest('#add_comment')[0].reset();
    });

    //обработчик форм
    $(function () {
        $(document).on('submit', "#add_comment, #auth_comment, #registration_comment", function () {
            let _this = $(this);
            let input = _this.serialize();
            let IdElement = _this.find("input[name='ID_ELEMENT']").attr('value');
            let Moderation = _this.find("input[name='MODERATION']").attr('value');
            let Action = _this.attr("id");//Определяет в какой ajax отправить данные
            let SiteDir = _this.find("input[name='SITE_DIR']").attr('value');
            let TEMPLATE = _this.find("input[name='TEMPLATE']").attr('value');
            //завершаем если нет Action
            if (typeof Action === "undefined") {
                return;
            }
            if (Action == 'registration_comment') {
                let register = $("input[name='register_submit_button']").attr('value');//добавление значения кнопки
                // для модуля
                let arparams = $("#registration_comment").attr("data-params");
                input = input + '&register_submit_button=' + register + '&arparams=' + arparams;
            }
            $.ajax({
                type: 'POST',
                url: SiteDir + 'bitrix/components/sotbit/reviews.comments.add/ajax/' + Action + '.php',
                data: input,
                success: function (data) {
                    if (data.trim() == 'SUCCESS') {
                        if (Action == 'auth_comment' || Action == 'registration_comment') {
                            location.reload();
                        } else {
                            $(_this)[0].reset();
                            $(_this).find('.count-now').html(0);
                            $(_this).closest('.reviews-body').find(".success").show();

                            if ($(_this).closest('.reviews-body').find(".success").attr('class') === undefined) {
                                $('#comments-body .success:first-child').show();
                            }

                            $(_this).closest('.spoiler-comments-body').toggle('normal');
                            if (Moderation != 'Y') {
                                BX.showWait();
                                $.ajax({
                                    type: 'POST',
                                    url: '/bitrix/components/sotbit/reviews.comments.add/ajax/reload_comments.php',
                                    data: {IdElement: IdElement, TEMPLATE: TEMPLATE},
                                    success: function (data) {
                                        $('#comments-list').html(data);
                                    },
                                    error: function (jqXHR, exception) {}
                                });
                                BX.closeWait();
                            }
                        }
                    } else {
                        if (Action == 'auth_comment' || Action == 'registration_comment') {
                            $('#comments-body').find("#" + Action + "-check-error").html(data);
                            $('#comments-body').find("#" + Action + "-check-error").show();
                            if (Action == 'registration_comment') {
                                change_captcha(_this, SiteDir);
                            }
                        } else {
                            $('#comments-body').find(".add-check-error").html(data);
                            $('#comments-body').find(".add-check-error").show();
                        }
                    }
                },
                error: function (jqXHR, exception) {
                }
            });

        });
    });

    function change_captcha(e, SiteDir) {
        $.ajax({
            type: 'POST',
            url: SiteDir + 'bitrix/components/sotbit/reviews.comments.add/ajax/change_captcha.php',
            success: function (data) {
                e.find("input[name='captcha_sid']").val(data);
                e.find("img").attr({"src": "/bitrix/tools/captcha.php?captcha_sid=" + data});
            },
            error: function (xhr, str) {
                alert(xhr.responseCode);
            }
        });
    }
});
