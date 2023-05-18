$(document).ready(function (){
    $('.check-all').click(function (){
        $('input[name="permissions[]"]').each(function (){
            $(this).prop("checked", true);
        });
    });
    $('.uncheck-all').click(function (){
        $('input[name="permissions[]"]').each(function (){
            $(this).prop("checked", false);
        });
    });
    $('.accordion-button a').on('click', function (){
        let href = $(this).attr('href');
        location.replace(`${href}`);
    })
});
