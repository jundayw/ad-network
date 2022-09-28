<?php

use JetBrains\PhpStorm\ArrayShape;

/**
 * 生成请求字符串
 * @param array $data
 * @param boolean $encode
 * @return string
 */
function http_build_redeclare(array $data = [], bool $encode = true): string
{
    $result = '';

    foreach ($data as $key => $item) {
        if (is_array($item)) {
            $item = http_build_redeclare($item, $encode);
        }
        if ($encode === true) {
            $item = rawurlencode($item);
        }
        $result .= "&{$key}={$item}";
    }

    return trim($result, '&');
}

/**
 * 密码生成
 * @param string $input
 * @param string|null $salt
 * @param callable|string $algo
 * @return string
 */
function password(string $input, string $salt = null, callable|string $algo = 'md5'): string
{
    return $algo($algo($input) . $salt);
}

/**
 * 密码验证
 * @param string $input
 * @param string $password
 * @param string|null $salt
 * @param callable|string $algo
 * @return boolean
 */
function password_check(string $input, string $password, string $salt = null, callable|string $algo = 'md5'): bool
{
    return $algo($algo($input) . $salt) == $password;
}

/**
 * 屏蔽显示字符串,支持电话和邮件的隐藏
 * @param string $input
 * @param int $before
 * @param int $after
 * @param string $split
 * @param string $shield
 * @return string
 */
function hidden(string $input, int $before = 4, int $after = 3, string $split = '', string $shield = '*'): string
{
    if (empty($input)) {
        return $input;
    }

    $suffix = '';

    if ($split) {
        [$input, $suffix] = explode($split, $input);
    }

    $start  = mb_substr($input, 0, $before, 'utf-8');
    $finish = mb_substr($input, -$after, $after, 'utf-8');
    // 解决长度不足问题
    if (mb_strlen($input, 'utf-8') <= $before + $after) {
        $input = sprintf('%s%s%s', $start, $shield, $finish);
    }
    // 需要显示的隐藏元素个数
    $len   = abs(mb_strlen($input, 'utf-8') - $before - $after);
    $input = sprintf('%s%s%s', $start, str_repeat($shield, $len), $finish);

    return empty($split) ? $input : $input . $split . $suffix;
}

/**
 * 比较
 * 1、函数可用于接口返回时，不特意关心状态或者信息的大小写
 * 2、精确逻辑防止逻辑错误
 * @param mixed $str1
 * @param mixed $str2
 * @param boolean $strict true:严格模式比较/false:非严格模式比较
 * @param boolean $case true:区分大小写/false:不区分大小写
 * @return boolean
 */
function compare(mixed $str1, mixed $str2, bool $strict = false, bool $case = false): bool
{
    if ($strict === false && $case === false) {
        if (is_string($str1)) {
            $str1 = strtolower($str1);
        }
        if (is_string($str2)) {
            $str2 = strtolower($str2);
        }
    }

    return $strict ? $str1 === $str2 : $str1 == $str2;
}

/**
 * 获取 $length 位数字
 * @param int $length
 * @return integer
 */
function generate_number(int $length = 6): int
{
    return rand(pow(10, $length - 1), pow(10, $length) - 1);
}

/**
 * 从 $chars 获取 $length 位字符串
 * @param int $length
 * @param string $chars
 * @return string|null
 */
function generate_string(int $length = 6, string $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'): ?string
{
    $string = null;

    for ($i = 0; $i < $length; $i++) {
        $string .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    return $string;
}

/**
 * 通用唯一识别码
 * @param string $format
 * @param callable|string $salt
 * @return string
 */
function generate_uuid(string $format = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x', callable|string $salt = 'strtoupper'): string
{
    $uuid = sprintf($format,
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),
        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,
        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,
        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );

    return $salt($uuid);
}

/**
 * 生成唯一(理论)编号
 * @param int $length
 * @param string $format
 * @param string|null $timestamp
 * @return string
 */
function generate_unlined(int $length = 20, string $format = 'YmdHis', string $timestamp = null): string
{
    $stamp = $timestamp === null ? date($format) : date($format, $timestamp);

    $stampLen = strlen($stamp);

    if ($length < $stampLen) {
        $length = $stampLen;
    }

    $limit = $length == $stampLen ? 1 : abs($length - $stampLen);

    $random = str_pad(mt_rand(1, pow(10, $limit) - 1), $limit, 0, STR_PAD_LEFT);

    return sprintf('%s%s', $stamp, $random);
}

/**
 * 获取格式时间
 * @param string|null $format
 * @param int|null $time
 * @return string
 */
function get_time(string $format = null, int $time = null): string
{
    $time = empty($time) ? time() : $time;

    $format = empty($format) ? 'Y-m-d H:i:s' : $format;

    return date($format, $time);
}

/**
 * 获取时间戳
 * @param boolean $as_float
 * @return float|int
 */
function get_timestamp(bool $as_float = false): float|int
{
    return $as_float === true ? microtime(true) : time();
}

/**
 * 枚举修改器
 * @param string $key
 * @param array $search
 * @param string|null $default
 * @return string
 */
function get_format_enumerate(string $key, array $search = [], string $default = null): string
{
    $item = strtolower($key);

    $search = array_change_key_case($search);

    if (array_key_exists($item, $search)) {
        return $search[$item];
    }

    return $default === null ? $key : $default;
}

/**
 * 日期修改器
 * @param string|null $date
 * @param string $format
 * @param string $default
 * @return string
 */
function get_format_date(string $date = null, string $format = 'Y-m-d H:i:s', string $default = '--'): string
{
    return empty($date) ? $default : date($format, $date);
}

/**
 * 货币修改器
 * @param mixed $money
 * @param int $decimals
 * @param string $format
 * @param string $default
 * @return string
 */
function get_format_money(mixed $money, int $decimals = 2, string $format = '￥', string $default = '--'): string
{
    return is_numeric($money) ? $default : $format . number_format($money, $decimals);
}

/**
 * 将阿拉伯数字转换成人民币大写
 * @param string $number 将金额数字当字符串传递，可防止被科学计数法
 * @return string
 */
function get_format_money_upper(string $number): string
{
    $char = ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'];

    $unit = ['', '拾', '佰', '仟'];

    $standard = ['元', '万', '亿', '兆', '京', '垓', '秭', '穰', '沟', '涧', '正', '载', '极'];

    $fractional = ['角', '分'];
    // 小数部分
    $decimal = function ($decimal) use ($char, $fractional) {
        // 保留2位有效位
        $decimal = substr($decimal, 0, 2);
        // 不足2位补充齐2位有效位
        $decimal = str_pad($decimal, 2, 0);

        $decimal = str_split($decimal);

        foreach ($decimal as $key => $item) {
            $decimal[$key] = $char[$item] . $fractional[$key];
        }

        return $decimal;
    };

    // 整数部分
    $integer = function ($integer) use ($char, $unit, $standard) {
        $integer = strrev($integer);

        $string = [];

        $integer = str_split($integer);

        foreach ($integer as $key => $item) {
            // 数字大写
            $string[$key] = $char[$item];
            // 单位填充
            $string[$key] .= $unit[$key % 4];
            // 千分位单位填充
            if ($key % 4 == 0) {
                $string[$key] .= $standard[ceil($key / 4)];
            }
        }

        return array_reverse($string);
    };
    // 左边0不计大写
    $number = ltrim($number, '0');

    [$int, $dec] = explode('.', $number);

    return implode('', array_merge($integer($int), $decimal($dec)));
}

/**
 * 默认值修改器
 * @param boolean $condition
 * @param mixed $format
 * @param mixed $default
 * @return mixed
 */
function get_format_default(bool $condition, mixed $format, mixed $default = '--'): mixed
{
    return $condition ? $format : $default;
}

/**
 * 函数对每一项都返回true，则返回true
 * @param array $input
 * @param callable $function
 * @return boolean
 */
function array_every(array $input, callable $function): bool
{
    foreach ($input as $key => $item) {
        if ($function($key, $item) === false) {
            return false;
        }
    }
    return true;
}

/**
 * 函数对任一项返回true，则返回true
 * @param array $input
 * @param callable $function
 * @return boolean
 */
function array_some(array $input, callable $function): bool
{
    foreach ($input as $key => $item) {
        if ($function($key, $item) === true) {
            return true;
        }
    }
    return false;
}

/**
 * 卸载并返回指定键值
 * @param array $data
 * @param array $keys
 * @return array
 */
function array_unset(array &$data = [], array $keys = []): array
{
    $callback = [];

    foreach ($keys as $item) {
        if (array_key_exists($item, $data)) {
            $callback[$item] = $data[$item];
        }
    }

    $data = array_diff_key($data, $callback);

    return $callback;
}

/**
 * 递归获取多维数组键值
 * @param array $data
 * @param string|null $key
 * @return array|null
 */
function array_key_recursive(array $data = [], string $key = null): ?array
{
    if ($key === null) {
        return $data;
    }

    $raw = $data;

    foreach (explode('.', $key) as $item) {
        if (array_key_exists($item, $raw) === false) {
            return null;
        }
        $raw = $raw[$item];
    }

    return $raw;
}

/**
 * 多维数组合并为一维数字
 * @param array $multi
 * @param string $prefix
 * @return array
 */
function multi2single(array $multi = [], string $prefix = ''): array
{
    static $result = [];

    foreach ($multi as $key => $item) {
        if (is_array($item)) {
            multi2single($item, $prefix . $key);
        } else {
            $result[$prefix . $key] = $item;
        }
    }

    return $result;
}

/**
 * 数组为空根据关联进行拷贝
 * @param array $data
 * @param array $map
 * @return array
 */
function completion(array $data = [], array $map = []): array
{
    foreach ($map as $key => $value) {
        if ($data[$key] === '') {
            $data[$key] = $value;
        }
    }
    return $data;
}

/**
 * 判定身份证有效性
 * @param string $identity
 * @param int $length
 * @return boolean
 */
function get_identity_card_number_validity(string $identity, int $length = 18): bool
{
    if (strlen($identity) != $length) {
        return false;
    }

    $identity = strtoupper($identity);
    $identity = str_split($identity);
    $validate = array_pop($identity);

    return $validate === get_luhm($identity);
}

/**
 * 根据身份证获取年龄
 * @param string $identity
 * @param boolean|string $year
 * @param int $length
 * @return boolean|number
 */
function get_identity_card_number_age(string $identity, bool|string $year = true, int $length = 18): bool|string
{
    if (get_identity_card_number_validity($identity, $length) === false) {
        return false;
    }

    $validate = substr($identity, 6, 4);

    if ($year === true) {
        $year = date('Y');
    }

    $age = $year - $validate;

    if ($age >= 0) {
        return $age;
    }

    return false;
}

/**
 * 根据身份证获取性别
 * @param string $identity
 * @param array $map
 * @param int $length
 * @return boolean|string
 */
function get_identity_card_number_gender(string $identity, array $map = ['MAN', 'WOMAN'], int $length = 18): bool|string
{
    if (get_identity_card_number_validity($identity, $length) === false) {
        return false;
    }
    // 从结尾处向前取2位保留正向1位
    $validate = substr($identity, -2, 1);

    [$true, $false] = $map;

    if (intval(fmod($validate, 2)) === 0) {
        return $false;
    }

    if (intval(fmod($validate, 2)) === 1) {
        return $true;
    }

    return false;
}

/**
 * 根据身份证获取出生年月
 * @param string $identity
 * @param string $format
 * @param int $length
 * @return boolean|string
 */
function get_identity_card_number_birthday(string $identity, string $format = 'Y-m-d', int $length = 18): bool|string
{
    if (get_identity_card_number_validity($identity, $length) === false) {
        return false;
    }
    // 从第6位后获取8位
    $validate  = substr($identity, 6, 8);
    $timestamp = strtotime($validate);

    if ($timestamp === false || $timestamp === -1) {
        return false;
    }

    return date($format, $timestamp);
}

/**
 * 根据身份证获取行政区划代码[结合地区数据库的行政区划代码获取相对应的省市县名称]
 * @param string $identity
 * @return array
 */
#[ArrayShape(['province' => "string", 'city' => "string", 'county' => "string"])]
function get_identity_card_number_area_code(string $identity): array
{
    return [
        'province' => str_pad(substr($identity, 0, 2), 6, 0, STR_PAD_RIGHT),
        'city' => str_pad(substr($identity, 0, 4), 6, 0, STR_PAD_RIGHT),
        'county' => substr($identity, 0, 6),
    ];
}

/**
 * 生成模拟身份证号码
 * @param array|string $code 行政区划代码：370883||array('370883',...)
 * @param array|string $age array(18,36)||19861001
 * @param boolean|null $gender true:MAN||false:WOMAN||null:(MAN||WOMAN)
 * @param integer $length
 * @return array|string
 */
function get_identity_card_number_rand(array|string $code, array|string $age = [18, 36], bool $gender = null, int $length = 1): array|string
{
    // MAN性别因子
    $man = [1, 3, 5, 7, 9];
    // WOMAN性别因子
    $woman = [0, 2, 4, 6, 8];

    $data = [];

    for ($i = 1; $i <= $length; $i++) {
        if (is_array($age)) {
            [$min, $max] = $age;
            // 出生年份区间
            $year = rand(date('Y') - $max, date('Y') - $min);
            // 出生月份
            $month = str_pad(rand(1, 12), 2, 0, STR_PAD_LEFT);
            // 出生日期，防止2月特殊，因此日期取到28最为保险
            $day = str_pad(rand(1, 28), 2, 0, STR_PAD_LEFT);
            // 出生年月
            $birthday = sprintf('%s%s%s', $year, $month, $day);
        } else {
            $birthday = $age;
        }
        // 性别随机
        if ($gender === null) {
            $gender = array_merge($man, $woman);
        }
        // 性别为MAN
        if ($gender === true) {
            $gender = $man;
        }
        // 性别为WOMAN
        if ($gender === false) {
            $gender = $woman;
        }
        // 性别码
        $gender = $gender[array_rand($gender, 1)];

        if (is_array($code)) {
            $code = $code[array_rand($code, 1)];
        }

        $identity = sprintf('%s%s%s%s', $code, $birthday, rand(10, 99), $gender);

        // 产生一个身份证号码
        $data[] = sprintf('%s%s', $identity, get_luhm($identity));
    }

    if ($length === 1) {
        $data = array_pop($data);
    }

    return $data;
}

/**
 * 模11算法生成校验码
 * @param array|string $digit
 * @return boolean|string
 * @example 身份证
 */
function get_luhm(array|string $digit): bool|string
{
    if (is_array($digit) === false) {
        $digit = str_split($digit);
    }

    if (array_every($digit, function ($item) {
            return is_numeric($item);
        }) === false) {
        return false;
    }

    $map    = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
    $sum    = [];
    $length = count($digit);

    foreach ($digit as $key => $item) {
        $weight = fmod(pow(2, $length - $key), 11);
        $sum[]  = $weight * $item;
    }

    $key = intval(fmod(array_sum($sum), 11));

    if (array_key_exists($key, $map)) {
        return $map[$key];
    }

    return false;
}

/**
 * 模10算法校验
 * @param array|string $digit
 * @return boolean
 * @example 银行卡、信用卡、IMEI
 */
function get_luhn_validity(array|string $digit): bool
{
    if (is_array($digit)) {
        $digit = implode('', $digit);
    }

    $digit    = str_split($digit);
    $validate = intval(array_pop($digit));

    return $validate === get_luhn($digit);
}

/**
 * 模10算法生成校验码
 * @param array|string $digit
 * @return boolean|int
 */
function get_luhn(array|string $digit): bool|int
{
    // 是否为数组
    if (is_array($digit)) {
        $digit = implode('', $digit);
    }
    // 分割为数组
    $digit = str_split($digit);
    // 数组尾部添加一个占位符
    $digit[] = 0;
    // 反转不保留原始健名
    $digit = array_reverse($digit, false);

    if (array_every($digit, function ($item) {
            return is_numeric($item);
        }) === false) {
        return false;
    }

    $pack = [];
    // luhn 算法:2X6-9={12}-9={1+2}
    foreach ($digit as $key => $item) {
        if (intval(fmod($key, 2)) === 1) {
            $item *= 2;
        }
        $pack[] = $item;
    }
    // 求和
    $sum  = array_sum(str_split(implode('', $pack)));
    $luhn = intval(fmod($sum, 10));

    return $luhn === 10 ? 0 : $luhn;
}

/**
 * 导出CSV文件
 * @param array $data
 * @param array $header
 * @param boolean|string $file
 * @param boolean|string $time
 */
function export_excel(array $data = [], array $header = [], bool|string $file = false, bool|string $time = true): void
{
    if ($file === false) {
        $file = null;
    }

    if ($time === true) {
        $time = get_time('YmdHis');
    }
    // 文件名
    $file = sprintf('%s-%s', $file, $time);
    // 过滤无效字符
    $file = trim($file, '-');
    // CSV 文件名称
    $file = sprintf('%s.csv', $file);
    // 设置内容类型
    header('Content-Type: application/vnd.ms-excel');
    // 设置文件名称
    header('Content-Disposition: attachment;filename=' . $file);
    // 设置缓存
    header('Cache-Control: max-age=0');

    $fp = fopen('php://output', 'a');
    // 设置文件页眉
    $head = [];
    // Excel 支持 GBK 编码，一定要转换，否则乱码
    foreach ($header as $key => $item) {
        $head[$key] = iconv('utf-8', 'gbk', $item);
    }
    // 将数据通过 fputcsv 写到文件句柄
    fputcsv($fp, $head);
    // 计数器
    $length = 0;
    // 每隔 $limit 行，刷新一下输出 buffer 不要太大，也不要太小
    $limit = 1000;
    // 计算数据长度
    $count = count($data);
    // 逐行取出数据，不浪费内存
    for ($i = 0; $i < $count; $i++) {
        $length++;
        // 刷新一下输出buffer，防止由于数据过多造成问题
        if ($limit == $length) {
            ob_flush();
            flush();
            $length = 0;
        }
        // 逐行取出数据
        $row = $data[$i];
        // 每行每个字段转码处理
        foreach ($row as $key => $item) {
            if (is_numeric($item)) {
                // 强制不使用科学计数法
                $item = sprintf('="%s"', $item);
            }
            // Excel 支持 GBK 编码，一定要转换，否则乱码
            $row[$key] = iconv('utf-8', 'gbk', $item);
        }
        // 将数据通过 fputcsv 写到文件句柄
        fputcsv($fp, $row);
    }
    // 释放文件句柄资源
    fclose($fp);
}

/**
 * 图片转base64编码
 * @param string $data
 * @param boolean $format
 * @param boolean $split
 * @return boolean|string
 */
function image_base64_encode(string $data, bool $format = true, bool $split = false): bool|string
{
    $image = getimagesize($data);

    $data = file_get_contents($data);

    if ($data === false) {
        return false;
    }

    $data = base64_encode($data);

    if ($format === true) {
        $data = sprintf('data:%s;base64,%s', $image['mime'], $data);
    }

    if ($split === true) {
        $data = chunk_split($data);
    }

    return $data;
}

/**
 * @param array|string $string $string
 * @param string $encoding GB2312//IGNORE, GB2312//TRANSLIT
 * @param string $prefix &#, &#x, \u, %u
 * @return array|string|null
 *
 * @example 新 => &#26032; = &#x65b0; = \u65b0 = %u65b0
 * @example a => &#0061; = &#x0061; = \u0061 = %u0061
 */
function unicode_encode(array|string $string, string $encoding = 'utf-8', string $prefix = '\u'): array|string|null
{
    return preg_replace_callback('/./u', function ($match) use ($encoding, $prefix) {
        // Convert string to requested character encoding
        $decimal = iconv($encoding, 'UCS-2', head($match));
        // Convert binary data into hexadecimal representation
        $decimal = bin2hex($decimal);
        if ($prefix == '&#') {
            $decimal = base_convert($decimal, 16, 10);
        }
        if (str_contains($prefix, '&#')) {
            $decimal .= ';';
        }
        return $prefix . $decimal;
    }, $string);
}

/**
 * @param array|string $string $string
 * @param string $encoding
 * @return array|string|null
 *
 * @example &#26032; = &#x65b0; = \u65b0 = %u65b0 => 新
 * @example &#0061; = &#x0061; = \u0061 = %u0061 => a
 */
function unicode_decode(array|string $string, string $encoding = 'utf-8'): array|string|null
{
    return preg_replace_callback('/(?P<format>&#|&#x|\\\\u|%u)(?P<decimal>[0-9a-f]{2,})(?P<postfix>;?)/i', function ($matches) use ($encoding) {
        $decimal = $matches['decimal'];
        if ($matches['format'] == '&#') {
            $decimal = base_convert($decimal, 10, 16);
        }
        $decimal = str_pad($decimal, 4, '0', STR_PAD_LEFT);
        return iconv('UCS-2', $encoding, pack('H*', $decimal));
    }, $string);
}
