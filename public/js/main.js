function createNode(data) {
    var $node = $("<div>").addClass("node");
    $("<span>").text(data.name).appendTo($node);
    if (data.children) {
        data.children.forEach(function(child) {
            createNode(child).appendTo($node);
        });
    }
    return $node;
}

jQuery(document).ready(function () {
    $('#createRoot').submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        jQuery.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function(response) {
                console.log(JSON.parse(response));
                $('#createRoot').trigger('reset');
                $('#createRootModal').modal('hide');
            },
            error: function(xhr) {
                let errors = JSON.parse(xhr.responseText);
                if (typeof errors.errors === 'string') {
                    alert(errors.errors);
                    $('#createRoot').trigger('reset');
                    $('#createRootModal').modal('hide');
                } else {
                        let field = Object.keys(errors.errors)[0];
                        $('#createRoot #'+ field).addClass('is-invalid');
                        let span = $('#createRoot #' + field + 'Error');
                        span.text(errors.errors[field]);
                        span.css("display", "block");
                }
            }
        });
    });
    $('#createRoot #title').on('input', function () {
        let span = $('#createRoot #titleError');
        span.text('');
        span.css("display", "none");
        $(this).removeClass('is-invalid');
    });
    $('#createNode #title').on('input', function () {
        let span = $('#createNode #titleError');
        span.text('');
        span.css("display", "none");
        $(this).removeClass('is-invalid');
    });
    $('button.create_node').on('click', function (event) {
        let parentId = $(this).data('parentid');
        $('#parent_id').val(parentId);
        $('#createNodeModal').modal('show');
    });
    $('#createNode').submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        jQuery.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function(response) {
                console.log(JSON.parse(response));
                $('#createNodeModal').modal('hide');
            },
            error: function(xhr) {
                let errors = JSON.parse(xhr.responseText);
                if (typeof errors.errors === 'string') {
                    alert(errors.errors);
                    $('#createNode').trigger('reset');
                    $('#createNodeModal').modal('hide');
                } else {
                    let field = Object.keys(errors.errors)[0];
                    $('#createNode #'+ field).addClass('is-invalid');
                    let span = $('#createNode #' + field + 'Error');
                    span.text(errors.errors[field]);
                    span.css("display", "block");
                }
            }
        });
    });

    $('#deleteRoot').submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        jQuery.ajax({
            url: $(this).attr('action'),
            type: 'DELETE',
            data: formData,
            success: function(response) {
                console.log(JSON.parse(response));
                $('#deleteRoot').trigger('reset');
                $('#deleteRootModal').modal('hide');
            },
            error: function(xhr) {
                let errors = JSON.parse(xhr.responseText);
                if (typeof errors.errors === 'string') {
                    alert(errors.errors);
                    $('#deleteRoot').trigger('reset');
                    $('#deleteRootModal').modal('hide');
                }
            }
        });
    });

    $('#deleteRootModal').on('shown.bs.modal', function() {
        let seconds = 60;
        let timer = $('#timer');
        timer.text(seconds);
        var countdown = setInterval(function() {
            seconds--;
            timer.text(seconds);
            if (seconds === 0) {
                clearInterval(countdown);
                $('#timer').text('');
                $('#deleteRootModal').modal('hide');
            }
        }, 1000);
        $('#deleteRootModal').on('hidden.bs.modal', function() {
            timer.text('');
            clearInterval(countdown);
        });
    });


});