$('.form').find('input, textarea').on('keyup blur focus', function (e) {

    var $this = $(this),
        label = $this.prev('label');

    if (e.type === 'keyup') {
        if ($this.val() === '') {
            label.removeClass('active highlight');
        } else {
            label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
        if ($this.val() === '') {
            label.removeClass('active highlight');
        } else {
            label.removeClass('highlight');
        }
    } else if (e.type === 'focus') {

        if ($this.val() === '') {
            label.removeClass('highlight');
        }
        else if ($this.val() !== '') {
            label.addClass('highlight');
        }
    }

});

$('.tab a').on('click', function (e) {

    e.preventDefault();

    $(this).parent().addClass('active');
    $(this).parent().siblings().removeClass('active');

    target = $(this).attr('href');

    $('.tab-content > div').not(target).hide();

    $(target).fadeIn(600);

});


function copyToClipboard(text) {
    const el = document.createElement('textarea');
    el.value = text;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    alert( 'Key Copied!')
}




$(document).ready(function() {
    $('#createMessageForm').submit(function(e) {
        e.preventDefault();

        let messageText = $('#recipient_text').val();
        let recipient = $('#recipient_email').val();
        
        $.ajax({
            url: 'create_message.php',
            type: 'POST',
            data: {
                messageText: messageText,
                recipient: recipient
            },
            success: function(response) {
                $("#recipient_email").val("");
                $("#recipient_email").parent().find("label").removeClass("active");
                
                $("#recipient_text").val("");
                $("#recipient_text").parent().find("label").removeClass("active");
                $('#response').html(response);
                setTimeout(() => {
                    $('#response').html('');
                }, 5000);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });


    $('#readMessageForm').submit(function(e) {
        e.preventDefault();

        let recipient_key = $('#recipient_key').val();
        $.ajax({
            url: 'read_message.php',
            type: 'POST',
            data: {
                recipient_key: recipient_key
            },
            success: function(response) {
                $("#recipient_key").val("");
                $("#recipient_key").parent().find("label").removeClass("active");
                $('#response2').html(response);
                setTimeout(() => {
                    $('#response2').html('');
                }, 5000);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});