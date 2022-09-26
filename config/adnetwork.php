<?php

return [
    // 广告位空闲配置
    'vacant' => [
        // 固定占位符广告：流量主主体主键，配置路径:换量广告>广告物料
        'fixed' => [1],
        // 换量广告：流量主主体主键，配置路径:换量广告>广告物料
        'exchange' => [2],
    ],
    // 无效广告展示物料
    'unavailable' => [
        'location' => 'javascript:void(0);',
        'image' => 'https://via.placeholder.com/400x400?text=unavailable',
        'callback' => 'test',
    ],
    'union' => [
        'link' => 'https://union.baidu.com/?adnetwork',
    ],
];
