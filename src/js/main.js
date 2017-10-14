$(document).ready(function(){

    $(".vtip").tipTip({
        defaultPosition: "right",
        maxWidth: '340px',
        delay: 100,
    });

    $('.profile-info input[type=radio]').change(function(){
        var url = $(this).data('url');
        $.ajax({
            url: url,
            method:'get',
        }).done(function(res){
            var $items = $(res).find('.profile-input-block').children();
            var $container = $('.profile-input-block');
            $container.children().remove();
            $container.append($items);

            $(".vtip").tipTip({
                defaultPosition: "right",
                maxWidth: '340px',
                delay: 100,
            });
        });
    });

});
