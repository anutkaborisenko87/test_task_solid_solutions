function createNode(type, attributes, children) {
    var node = document.createElement(type);

    for (var key in attributes) {
        if (attributes.hasOwnProperty(key)) {
            node.setAttribute(key, attributes[key]);
        }
    }

    if (children) {
        for (var i = 0; i < children.length; i++) {
            var child = children[i];
            if (typeof child === 'string') {
                node.appendChild(document.createTextNode(child));
            } else {
                node.appendChild(createNode(child.type, child.attributes, child.children));
            }
        }
    }

    return node;
}

$(document).ready(function () {
    $('ul.submenu').hover(
        function() {
            $(this).parent().addClass('hover');
        },
        function() {
            $(this).parent().removeClass('hover');
        }
    );
});