$(document).ready(function () {
    function store(name, val) {
        if (typeof (Storage) !== "undefined") {
            localStorage.setItem(name, val);
        } else {
            window.alert('Please use a modern browser to properly view this template!');
        }
    }

    function get(name) {
        if (typeof (Storage) !== "undefined") {
            return localStorage.getItem(name)
        } else {
            window.alert('Please use a modern browser to properly view this template!');
        }
    }

    function theme() {
        let current = get('theme');
        let element = $('#theme');
        let origin = element.attr('href').split('/');
        if (current) {
            origin.splice(origin.length - 1, 1, [current, 'css'].join('.'));
            element.attr('href', origin.join('/'));
        }
        $('*[theme]').each(function (index, element) {
            if (index == 0 || $(this).attr('theme') == current) {
                $('*[theme]').removeClass('working');
                $(this).addClass('working')
            }
        });
    }

    $("*[theme]").click(function (e) {
        e.preventDefault();
        store('theme', $(this).attr('theme'));
        theme();
    });
    theme();
});
