jQuery(document).ready(function () {
    let contentdata = JSON.parse($('#datacontent').html());
    function getMenuData() {
        $.ajax({
            url: '/get_roots', // Замените на свой URL
            dataType: 'json',
            success: function (response) {
                contentdata = response.data;
                renderMenu(contentdata);
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    }

    /**
     * @param menuItems
     * @param classVal
     * @returns {jQuery|HTMLElement|*}
     */
    function rendersubMenu(menuItems, classVal = "topmenu") {
        let ul = $("<ul>", {class: classVal});

        $.each(menuItems, function (i, item) {
            let li = $("<li>");
            let a = $("<a>", {href: "#"}).html(
                (item.nodes && item.nodes.length) ? '<span class="menu-icon">▶</span>' : ""
            ).append(item.title);
            let button = $("<button>", {
                type: "button",
                class: "btn btn-outline-success btn-sm create_node",
                "data-parentId": item.id
            }).text("+");
            let button2 = $("<button>", {
                type: "button",
                class: "btn btn-outline-danger btn-sm delete_node",
                "data-nodeId": item.id,
                "data-nodetitle": item.title,
                "data-toggle": "modal",
                "data-target": "#deleteNodeModal"
            }).text("-");

            a.append(button).append(button2);

            if (item.nodes && item.nodes.length) {
                let classVal = item.depth === 0 ? "submenu" : "submenu subsubmenu";
                li.append(rendersubMenu(item.nodes, classVal));
            }

            li.append(a);
            ul.append(li);
        });

        return ul;
    }

    /**
     * @param contentdata
     */
    function renderMenu(contentdata) {
        $('#content').empty();
        $.each(contentdata, function (i, item) {
            if (item.parent_id === null) {
                let row = $("<div>", {class: "row"});
                let nav = $("<div>", {class: "nav"});
                let ul = $("<ul>", {class: "topmenu"});

                if (item.nodes && item.nodes.length) {
                    let li = $("<li>");
                    let a = $("<a>", {href: "#"}).text(item.title);
                    a.prepend('<span class="menu-icon">▶</span>');
                    let button1 = $("<button>", {
                        type: "button",
                        class: "btn btn-outline-success btn-sm create_node",
                        "data-parentId": item.id,
                        "data-toggle": "modal",
                        "data-target": "#createNodeModal"
                    }).text("+");
                    let button2 = $("<button>", {
                        type: "button",
                        class: "btn btn-outline-danger btn-sm delete_root",
                        "data-rootId": item.id,
                        "data-toggle": "modal",
                        "data-target": "#deleteRootModal"
                    }).text("-");

                    a.append(button1).append(button2);
                    li.append(a).append(rendersubMenu(item.nodes, "submenu"));
                    ul.append(li);
                } else {
                    let li = $("<li>");
                    let a = $("<a>", {href: "#"}).text(item.title);
                    let button1 = $("<button>", {
                        type: "button",
                        class: "btn btn-outline-success btn-sm create_node",
                        "data-parentId": item.id,
                        "data-toggle": "modal",
                        "data-target": "#createNodeModal"
                    }).text("+");
                    let button2 = $("<button>", {
                        type: "button",
                        class: "btn btn-outline-danger btn-sm delete_root",
                        "data-rootId": item.id,
                        "data-toggle": "modal",
                        "data-target": "#deleteRootModal"
                    }).text("-");

                    a.append(button1).append(button2);
                    li.append(a);
                    ul.append(li);
                }

                nav.append(ul);
                row.append(nav);

                $("#content").append(row);
            }
        });
    }

    getMenuData(contentdata);

    $('#createRoot #title').on('input', function () {
        let span = $('#createRoot #titleError');
        span.text('');
        span.css("display", "none");
        $(this).removeClass('is-invalid');
    });

    $('#createNode #title').on('input', function (event) {
        let span = $('#createNode #titleError');
        span.text('');
        span.css("display", "none");
        $(this).removeClass('is-invalid');
    });

    $('body').on('click', 'button.create_node', function (event) {
        let parentId = $(this).data('parentid');
        $('#parent_id').val(parentId);
        $('#createNodeModal').modal('show');
    });

    $('body').on('click', 'button.delete_node', function (event) {
        let nodeId = $(this).data('nodeid');
        let nodeTitle = $(this).data('nodetitle');
        $('#deleteNodeModal p#confirmation_text').text('You try to delete ' + nodeTitle);
        $('#deleteNodeModal #node_id').val(nodeId);
        $('#deleteNodeModal').modal('show');
    });

    $('body').on('click', 'button.delete_root', function (event) {
        let rootId = $(this).data('rootid');
        $('#root_id').val(rootId);
        $('#deleteRootModal').modal('show');
    });

    $('#createRoot').submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();
        jQuery.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function (response) {
                getMenuData();
                let message = JSON.parse(response)
                alert(message.data)
                $('#createRoot').trigger('reset');
                $('#createRootModal').modal('hide');
            },
            error: function (xhr) {
                let errors = JSON.parse(xhr.responseText);
                if (typeof errors.errors === 'string') {
                    alert(errors.errors);
                    $('#createRoot').trigger('reset');
                    $('#createRootModal').modal('hide');
                } else {
                    let field = Object.keys(errors.errors)[0];
                    $('#createRoot #' + field).addClass('is-invalid');
                    let span = $('#createRoot #' + field + 'Error');
                    span.text(errors.errors[field]);
                    span.css("display", "block");
                }
            }
        });
    });

    $('#createNode').submit(function (event) {
        event.preventDefault();
        let formData = $(this).serialize();
        jQuery.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function (response) {
                getMenuData();
                let message = JSON.parse(response);
                alert(message.data);
                $('#createNode').trigger('reset');
                $('#createNodeModal').modal('hide');
            },
            error: function (xhr) {
                let errors = JSON.parse(xhr.responseText);
                if (typeof errors.errors === 'string') {
                    alert(errors.errors);
                    $('#createNode').trigger('reset');
                    $('#createNodeModal').modal('hide');
                } else {
                    let field = Object.keys(errors.errors)[0];
                    $('#createNode #' + field).addClass('is-invalid');
                    let span = $('#createNode #' + field + 'Error');
                    span.text(errors.errors[field]);
                    span.css("display", "block");
                }
            }
        });
    });

    $('#deleteRoot').submit(function (event) {
        event.preventDefault();
        let rootId = $('#deleteRoot #root_id').val();
        let formData = $(this).serialize();
        jQuery.ajax({
            url: $(this).attr('action') + "?root_id=" + rootId,
            type: 'DELETE',
            data: formData,
            success: function (response) {
                getMenuData();
                let message = JSON.parse(response)
                alert(message.data)
                $('#deleteRoot').trigger('reset');
                $('#deleteRootModal').modal('hide');
            },
            error: function (xhr) {
                let errors = JSON.parse(xhr.responseText);
                if (typeof errors.errors === 'string') {
                    alert(errors.errors);
                    $('#deleteRoot').trigger('reset');
                    $('#deleteRootModal').modal('hide');
                }
            }
        });
    });

    $('#deleteNode').submit(function (event) {
        event.preventDefault();
        let nodeId = $('#deleteNode #node_id').val();
        let formData = $(this).serialize();
        jQuery.ajax({
            url: $(this).attr('action') + "?node_id=" + nodeId,
            type: 'DELETE',
            data: formData,
            success: function (response) {
                getMenuData();
                let message = JSON.parse(response)
                alert(message.data)
                $('#deleteNode').trigger('reset');
                $('#deleteNodeModal p#confirmation_text').text('');
                $('#deleteNodeModal').modal('hide');
            },
            error: function (xhr) {
                let errors = JSON.parse(xhr.responseText);
                if (typeof errors.errors === 'string') {
                    alert(errors.errors);
                    $('#deleteNode').trigger('reset');
                    $('#deleteNodeModal p#confirmation_text').text('');
                    $('#deleteNodeModal').modal('hide');
                }
            }
        });
    });

    $('#deleteRootModal').on('shown.bs.modal', function () {
        let seconds = 60;
        let timer = $('#timer');
        timer.text(seconds);
        var countdown = setInterval(function () {
            seconds--;
            timer.text(seconds);
            if (seconds === 0) {
                clearInterval(countdown);
                $('#timer').text('');
                $('#deleteRootModal').modal('hide');
            }
        }, 1000);
        $('#deleteRootModal').on('hidden.bs.modal', function () {
            timer.text('');
            clearInterval(countdown);
        });
    });


});