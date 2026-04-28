jQuery(function ($) {

    let page = 1;
    const btn = $('#load-more-btn');
    const container = $('#galeria-container');

    btn.on('click', function () {

        $.ajax({
            url: situr_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_images',
                page: page,
            },
            beforeSend: function () {
                btn.text('Cargando...');
                btn.prop('disabled', true);
            },
            success: function (response) {

                if (response.trim() !== '') {
                    container.append(response);
                    page++;
                    btn.text('Cargar más');
                    btn.prop('disabled', false);
                } else {
                    btn.hide();
                }
            }
        });

    });

});