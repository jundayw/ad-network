$(function () {
    $('[rel-action=select]').each(function () {
        $(this).select2();
    });
    $('[rel-action=datetimepicker]').each(function () {
        $(this).datetimepicker({
            language: 'zh-CN',
            format: 'yyyy-mm-dd hh:ii:00',
            autoclose: true,
            todayBtn: true,
            clearBtn: true
        });
    });
    $('[rel-action=datepicker]').each(function () {
        $(this).datetimepicker({
            language: 'zh-CN',
            format: 'yyyy-mm-dd',
            minView: "month",
            autoclose: true,
            todayBtn: true,
            clearBtn: true
        });
    });
    $('[rel-action=timepicker]').each(function () {
        $(this).datetimepicker({
            language: 'zh-CN',
            format: 'hh:ii:00',
            startView: 'day',
            maxView: 'day',
            autoclose: true,
            todayBtn: true,
            clearBtn: true
        });
    });
    $('[rel-action=file]').each(function () {
        var element = this;
        var target = $(element).attr('rel-target');
        var targetName = $(target).attr('name');
        var url = $(element).attr("rel-url");
        var method = $(element).attr("rel-method") || 'POST';
        $(element).change(function () {
            if (element.files.length == 0) {
                return false;
            }
            var data = new FormData();
            for (var i = 0; i < element.files.length; i++) {
                data.append([targetName, '[', i, ']'].join(''), element.files[i]);
            }
            $.ajax({
                url: url,
                type: method,
                data: data,
                contentType: false,
                processData: false,
                success: function (data, textStatus) {
                    data = $.correct(data);
                    layer.msg(data.message, {
                        shift: data.state ? 2 : 6
                    });
                    if (data.state === false || data.state === undefined) {
                        return false;
                    }
                    $(target).data('value', $(target).val());
                    $(target).val(data.data[targetName].join(','));
                    $(element).trigger('file:upload.success', [data, data.data[targetName]]);
                    $(target).trigger('file:upload.success', [data, data.data[targetName]]);
                },
                error: function (XmlHttpRequest, textStatus, errorThrown) {
                    $(element).trigger('file:upload.error');
                    $(target).trigger('file:upload.error');
                }
            });
            return false;
        });
    });
});
