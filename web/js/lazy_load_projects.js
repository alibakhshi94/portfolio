$(function () {
    var all_item_count = item_count;

    function loadMore() {
        if (next_count > 0) {
            append_preload();
            render_next_item();
        }
        $(window).bind('scroll', bindScroll);
    }

    function bindScroll() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - ($(document).height() * 0.1)) {
            $(window).unbind('scroll');
            loadMore();
        }
    }

    function render_next_item() {
        var route;
        if (category) {
            route = Routing.generate('portfolio_category_next_projects', {slug: category, limit: 8, offset: all_item_count});
        } else {
            route = Routing.generate('portfolio_next_projects', {limit: 8, offset: all_item_count});
        }
        next_count = 0;
        $.get(route, function (data) {
            all_item_count += data['data'].length;
            next_count = data['nextCount'];
            var preload_items = $('.project-cell_load');
            $.each(data['data'], function (index, value) {
                if (!preload_items[index]){
                    $('.items_projects').append('<li class="project-cell">' + value + '</li>');
                } else {
                    $(preload_items[index]).append(value);
                    $(preload_items[index]).removeClass('project-cell_load');
                    $(preload_items[index]).find('.container_load').remove();
                }
            });
        });
    }

    $(window).scroll(bindScroll);

    function append_preload() {
        var preload_block = '<li class="project-cell project-cell_load"><div class="container_load"><div class="loader"><svg class="circular"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="1" stroke-miterlimit="10"/></svg></div></div></li>';
        for (var i = 0; i < next_count; i++) {
            $('.items_projects').append(preload_block);
        }

        if($(".project-cell").length) {
            var a = $(".project-cell:eq(2)").height();
            $(".container_load").height(a);
            $(window).resize(function () {
                a = $(".project-cell:eq(2)").height();
                $(".container_load").height(a);
            });
        }
    }
});
