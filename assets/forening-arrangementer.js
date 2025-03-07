jQuery(document).ready(function($) {
    $('#tilfoj-arrangement-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        formData += '&post_id=' + forening_arrangementer_ajax.post_id + '&action=gem_arrangement&nonce=' + forening_arrangementer_ajax.nonce;
        $.post(forening_arrangementer_ajax.ajax_url, formData, function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Fejl: ' + response.data);
            }
        });
    });

    $(document).on('click', '.slet-arrangement', function() {
        var arrangementId = $(this).data('id');
        var formData = 'post_id=' + forening_arrangementer_ajax.post_id + '&arrangement_id=' + arrangementId + '&action=slet_arrangement&nonce=' + forening_arrangementer_ajax.nonce;
        $.post(forening_arrangementer_ajax.ajax_url, formData, function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Fejl: ' + response.data);
            }
        });
    });

    $('#opdater-baggrundsbillede-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('action', 'opdater_baggrundsbillede');
        formData.append('nonce', forening_arrangementer_ajax.nonce);
        formData.append('post_id', forening_arrangementer_ajax.post_id);
        $.ajax({
            url: forening_arrangementer_ajax.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Fejl: ' + response.data);
                }
            }
        });
    });
});
