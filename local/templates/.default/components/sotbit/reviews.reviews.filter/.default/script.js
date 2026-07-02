$(document).ready(function () {
    $(document).on('click', '#current-option-select-rating',
        function () {
            const customOptionsBlock = $("#custom-options-select-rating");

            // if (customOptionsBlock.is(":hidden")) {
            //     $("#select-rating").attr("class", "select-rating-open");
            // }
            //
            // $("#custom-options-select-rating").slideToggle('normal', function () {
            //
            //     if (customOptionsBlock.is(":hidden")) {
            //         //$("#custom-options-select-rating").show();
            //         $("#select-rating").attr("class", "select-rating-close");
            //     } else {
            //         //$("#custom-options-select-rating").hide();
            //         //$("#select-rating").attr("class","select-rating-open");
            //
            //     }
            // });

            if (customOptionsBlock.is(":hidden")) {
                $("#custom-options-select-rating").show();
                $("#select-rating").attr("class", "select-rating-open");
            } else {
                $("#custom-options-select-rating").hide();
                $("#select-rating").attr("class","select-rating-close");
            }

        });

    $(document).on('click', '#custom-options-select-rating li',
        function () {
            const oldValue = $("#current-option-select-rating").attr("data-value");
            const choosenValue = $(this).attr("data-value");
            $("#current-option-select-rating .current-option-select-rating-span").html($(this).html());
            $("#current-option-select-rating").attr("data-value", choosenValue);
            //$("#custom-options-select-rating").hide();
            $("#custom-options-select-rating").slideToggle('normal', function () {
                $("#select-rating").attr("class", "select-rating-close");
            });
            if (oldValue !== choosenValue) {
                ReloadReviews(1);
            }
        });

    $(document).on('change', '#filter-images',
        function () {
            if ($(this).attr("data-value") == "Y")
                $(this).attr("data-value", "N");
            else
                $(this).attr("data-value", "Y");
            ReloadReviews(1);
        });


    $(document).on('click', '#current-option-select-sort',
        function () {
            const customOptionsBlock = $("#custom-options-select-sort");
            // if (customOptionsBlock.is(":hidden")) {
            //     $("#select-sort").attr("class", "select-rating-open");
            // }

            // $("#custom-options-select-sort").slideToggle('normal', function () {
            //     if (customOptionsBlock.is(":hidden")) {
            //         //$("#custom-options-select-sort").show();
            //         $("#select-sort").attr("class", "select-rating-close");
            //     } else {
            //         //$("#custom-options-select-sort").hide();
            //         //$("#select-sort").attr("class","select-rating-open");
            //
            //     }
            // });

            if (customOptionsBlock.is(":hidden")) {
                $("#custom-options-select-sort").show();
                $("#select-sort").attr("class", "select-rating-open");
            } else {
                $("#custom-options-select-sort").hide();
                $("#select-sort").attr("class","select-rating-close");

            }
        });

    $(document).on('click', '#custom-options-select-sort li',
        function () {
            const oldOrder = $("#current-option-select-sort").attr("data-sort-order");
            const oldBy = $("#current-option-select-sort").attr("data-sort-by");
            const choosenOrder = $(this).attr("data-sort-order");
            const choosenBy = $(this).attr("data-sort-by");
            $("#current-option-select-sort .reviews-filter__selected-text").text($(this).text());
            $("#current-option-select-sort").attr("data-sort-order", choosenOrder);
            $("#current-option-select-sort").attr("data-sort-by", choosenBy);
            //$("#custom-options-select-sort").hide();
            //$("#select-sort").attr("class","select-rating-close");
            $("#custom-options-select-sort").slideToggle('normal', function () {
                $("#select-sort").attr("class", "select-rating-close");
                $("#current-option-select-sort").find('.fa-angle-up').removeClass("fa-angle-up").addClass("fa-angle-down");
            });
            if (oldOrder != choosenOrder || oldBy != choosenBy) {
                ReloadReviews(1);
            }
        });
});
