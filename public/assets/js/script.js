
console.log('script.js')

$(document).on('click', '[data-action="bootbox"]', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');

    $.ajax({
        type: 'GET',
        url: url,
        success: function(response) {
            bootbox.dialog({
                title: "Modal Title",
                message: response,
                size: 'large',
                buttons: {
                    ok: {
                        label: 'OK',
                        className: 'btn-success',
                        callback: function() {
                            console.log('OK button clicked');
                        }
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-danger',
                        callback: function() {
                            console.log('Cancel button clicked');
                        }
                    }
                }
            });
        },
        error: function() {
            bootbox.alert('An error occurred during the request.');
        }
    });
});
