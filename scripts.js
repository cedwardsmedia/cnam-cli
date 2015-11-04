var save_creds = function() {
    $.post('/auth.php',
        {
            sid: $('#sid').val(),
            token: $('#token').val()
        }, function(data) {
            if (data.status === 'error') {
                $('#CredentialsStatus')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .show()
                    .html(data.payload.message);
            } else {
                $('#CredentialsStatus')
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .show()
                    .html(data.payload.message);
            }
        },
        'json'
    );
};
