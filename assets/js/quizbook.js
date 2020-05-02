(function($) {
    $('#quizbook ul li .answer').on('click', function() {
        $(this).siblings().removeAttr('data-selected');
        $(this).siblings().removeClass('selected');
        $(this).addClass('selected');
        $(this).attr('data-selected', true);
    });

    $('#quizbook_send').on('submit', function(e) {
        e.preventDefault();

        var answers = $('[data-selected]');
        var id_answers = [];

        $.each(answers, function (key, value) {
            id_answers.push(value.id);
        });

        var data = {
            action: 'quizbook_results',
            data: id_answers
        }
        $.ajax({
            url: admin_url.ajax_url,
            type: 'post',
            data: data
        }).done(function (response) {
            var message;
            if (response.total > 60) {
                message = 'aprobado';
            } else {
                message = 'no-aprobado'; 
            }

            $('#qb_response_result').append(`Total: ${response.total}`).addClass(message);
            $('#qb_btn_submit').remove();
        });

    });

    
})(jQuery);