(function (window, $, undefined) {
    // 生成随机字符
    $.generateRandom = function (option) {
        var config = {
            chars: '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            length: 10,// 输出长度
            delimiter: '',// 分隔符
        };
        option = $.extend(config, option);
        var random = new Array();
        for (var i = 0; i < option.length; i++) {
            random.push(option.chars.charAt(Math.floor(Math.random() * option.chars.length)))
        }
        return random.join(option.delimiter);
    };
    // 通用唯一识别码
    $.uuid = function () {
        var uuid = "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx";
        return uuid.replace(/[xy]/g, function (e) {
            var item = 16 * Math.random() | 0;
            return ("x" === e ? item : 3 & item | 8).toString(16);
        });
    };
    // 解析URL
    $.URL = function (url) {
        url = url || document.location.href;
        url = new URL(url);
        url.param = function (key) {
            return url.searchParams.get(key) || null;
        };
        return url;
    };
    $.correct = function (data) {
        data = {
            state: data.state,
            message: data.state ? data.message : data.error,
            data: data.state ? data.data : data.errors,
            url: data.url,
            location: window.location.href,
        };
        console.log(data);
        return data;
    };
    // 对Date的扩展，将 Date 转化为指定格式的String
    // 月(M)、日(d)、小时(H)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，
    // 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
    // 例子：
    // (new Date()).Format("yyyy-MM-dd HH:mm:ss.S") ==> 2006-07-02 08:09:04.423
    // (new Date()).Format("yyyy-M-d H:m:s.S")      ==> 2006-7-2 8:9:4.18
    Date.prototype.Format = function (fmt) {
        var o = {
            "M+": this.getMonth() + 1,
            "d+": this.getDate(),
            "H+": this.getHours(),
            "m+": this.getMinutes(),
            "s+": this.getSeconds(),
            "S+": this.getMilliseconds()
        };
        //因为date.getFullYear()出来的结果是number类型的,所以为了让结果变成字符串型，下面有两种方法：
        if (/(y+)/.test(fmt)) {
            //第一种：利用字符串连接符“+”给date.getFullYear()+""，加一个空字符串便可以将number类型转换成字符串。
            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        }
        for (var k in o) {
            if (new RegExp("(" + k + ")").test(fmt)) {
                //第二种：使用String()类型进行强制数据类型转换String(date.getFullYear())，这种更容易理解。
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(String(o[k]).length)));
            }
        }
        return fmt;
    };
    $.fn.dateTime = function (attribute) {
        var element = this;
        setInterval(function () {
            $(element).attr(attribute, (new Date()).Format("yyyy-MM-dd HH:mm:ss"));
        }, 1000);
    };
})(window, jQuery);