function modal(id) {
    $('#modal_form #title').html(
        $('#w'+id+' .title').html()
    );
    $('#modal_form #text').html(
        $('#w'+id+' .text').html()
    );
    //$('body').css('overflow', 'hidden');
    $('#overlay').fadeIn(400, function(){
        $('#modal_form')
            .css('display', 'block')
            .animate({opacity: 1}, 200);
        ($('#text').height() < 268) ? 
            height = $('#text').height() + $('#title').height() + 9 :
            height = 268 + $('#title').height() + 9 ;
        $('#modal_form').css('height', height);
    });
}

$(document).ready(function() {
    $('#modal_close, #overlay').click( function(){
    //$('body').css('overflow', 'auto');
    $('#modal_form')
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                $('#overlay').fadeOut(400);
            }
        );
    });

    $('#form').on( "submit", function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/admin.php?do=config",
            data: $('#form').serialize(),
            success: function(data){
                alert(data);
            }
        });
    });
});

