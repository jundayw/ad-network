$(function () {
    // NProgress.configure({parent: 'body'});
    // NProgress.start();
    // NProgress.done();
    $(document).ajaxStart(function () {
        // NProgress.start();
    });
    $(document).ajaxComplete(function () {
        // NProgress.done();
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('submit', '[rel-action=submit]', function () {
        var url = $(this).attr("action");
        var data = $(this).serialize();
        var method = $(this).attr("method");
        var dataType = $(this).data("type") || 'json';
        var callback = $(this).attr("rel-callback") || 'document.location.href = data.url;';
        $.ajax({
            url: url,
            data: data,
            type: method,
            dataType: dataType,
            beforeSend: function (XMLHttpRequest) {
            },
            success: function (data, textStatus) {
                data = $.correct(data);
                layer.msg(data.message, {
                    shift: data.state ? 2 : 6
                });
                if (data.state === false || data.state === undefined) {
                    return false;
                }
                window.setTimeout(function () {
                    (new Function('data', ['return', callback, ';console.log(data);'].join(' ')))(data);
                }, 1000);
            },
            complete: function (XMLHttpRequest, textStatus) {
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.msg(XMLHttpRequest.statusText, {
                    shift: 2
                });
            }
        });
        return false;
    });
    $(document).on('click', '[rel-action=confirm]', function () {
        var title = $(this).attr("rel-title") || "确认信息";
        var btnCertain = $(this).attr("rel-certain") || "确定";
        var btnCancel = $(this).attr("rel-cancel") || "取消";
        var url = $(this).attr("href") || $(this).attr("rel-url");
        var msg = $(this).attr("rel-msg") || $(this).attr("title") || "确定执行该操作？";
        var callback = $(this).attr("rel-callback") || 'document.location.href = data.url';
        layer.confirm(msg, {
            title: title,
            btn: [btnCertain, btnCancel]
        }, function () {
            $.get(url, function (data) {
                data = $.correct(data);
                layer.msg(data.message, {
                    shift: data.state ? 2 : 6
                });
                if (data.state === false || data.state === undefined) {
                    return false;
                }
                window.setTimeout(function () {
                    (new Function('data', ['return', callback, ';console.log(data);'].join(' ')))(data);
                }, 1000);
            });
        });
        return false;
    });
    $(document).on('click', '[rel-action=dialog]', function () {
        var id = $(this).attr('rel-id') || '';
        var title = $(this).attr("title") || $(this).attr('rel-title');
        var shade = $(this).attr("rel-shade") || 0.8;
        var shadeClose = $(this).attr("rel-shade-close") || true;
        var offset = $(this).attr("rel-offset") || 'auto';
        offset = offset.indexOf(',') === -1 ? offset : offset.split(',');
        var width = $(this).attr("rel-width") || 768;
        var height = $(this).attr("rel-height") || 480;
        var url = $(this).attr("href") || $(this).attr('rel-url');
        width = window.screen.availWidth > width ? width : window.screen.availWidth - 20;
        height = window.screen.availHeight > height ? height : window.screen.availHeight - 20;
        layer.open({
            id: id,
            type: 2,
            title: title,
            shade: JSON.parse(shade),
            shadeClose: JSON.parse(shadeClose),
            offset: offset,
            //closeBtn: false,
            area: [width + 'px', height + 'px'],
            content: url
        });
        return false;
    });
    $(document).on('click', '[rel-action=captcha]', function () {
        var captcha = $(this).attr('src');
        if (!$(this).data('src')) {
            $(this).data('src', captcha);
        }
        var captcha = $(this).data('src');
        $(this).attr('src', [captcha, (new Date()).getTime()].join(captcha.indexOf('?') == -1 ? '?' : '&'));
    });
    $(document).on('click', '[rel-action=dialog-close]', function () {
        parent.layer.close(parent.layer.getFrameIndex(window.name));
    });
    $(document).on('click', '[rel-action=back]', function () {
        history.back();
    });
    // // 图片放大效果
    // $(document).on('click', '[rel-action=zoom] img:not(.nozoom)', function () {
    //     layer.open({
    //         type: 1,
    //         title: false,
    //         shade: 0.8,
    //         shadeClose: true,
    //         area: ['auto', 'auto'],
    //         content: "<img src='" + $(this).attr('src') + "' style='max-width:800px;min-width:100px;max-height:800px;min-height:100px;'>",
    //     });
    // });
    // $(document).on("click", "[rel-action=choose]", function () {
    //     var title = $(this).attr('rel-title') || '请选择';
    //     var shade = $(this).attr("rel-shade") || 0.8;
    //     var width = $(this).attr("rel-width") || 768;
    //     var height = $(this).attr("rel-height") || 480;
    //     var url = $(this).attr('rel-url');
    //     var target = $(this).attr('rel-target');
    //     width = window.screen.availWidth > width ? width : window.screen.availWidth - 20;
    //     height = window.screen.availHeight > height ? height : window.screen.availHeight - 20;
    //     layer.open({
    //         type: 2,
    //         title: title,
    //         shade: parseFloat(shade),
    //         shadeClose: true,
    //         area: [width + 'px', height + 'px'],
    //         content: url,
    //         success: function (layero, index) {
    //             layer.getChildFrame('body', index).find('[rel-target]').val(target);
    //         }
    //     });
    //     return false;
    // });
    // $(document).on("click", "[rel-choose]", function () {
    //     var message = $(this).attr('rel-message') || '选择成功';
    //     var target = $('[rel-target]').val();
    //
    //     layer.msg(message);
    //     parent.$(target).val($(this).attr('rel-choose'));
    //     parent.$(target).trigger('choose', [$(this).attr('rel-choose'), $(this).attr('rel-title')]);
    //     window.setTimeout(function () {
    //         parent.layer.close(parent.layer.getFrameIndex(window.name));
    //     }, 1000);
    //
    //     return false;
    // });
    // $(document).on('click', '[rel-action=cls]', function () {
    //     $($(this).attr('rel-target')).val('');
    // });
});
