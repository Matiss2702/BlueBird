$('document').ready(function(){
    $('#is_home').on('change', function(){
        if ($(this).val() == 1) {
            $('#slug').attr('readonly', true);
            $('#slug').val('/');
        } else {
            $('#slug').attr('readonly', false);
            $('#title').trigger('change');
        }
    });

    $('#is_home').trigger('change');

    $('#title').on('change', function(){
        if ($('#is_home').val() == 0) {
            $('#slug').val('/' + $(this).val().toLowerCase().trim().replace(/[^a-z0-9]+/g, '-'));
        }
    });
});