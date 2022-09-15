<?php

return [
    'controller' => 'App\Http\Controllers',    // 控制器命名空间
    'model' => 'App\Models',                   // 模型命名空间
    'repository' => 'App\Repositories',        // 仓库命名空间
    'request' => 'App\Http\Requests',          // 表单验证命名空间
    'view' => 'resources\views',               // 视图模板路径
    'publishes' => [
        'stubs' => 'artisan-generator-stubs',   // 通过修改命令模板配置可生成多套命令模板
        'views' => 'artisan-generator-views',   // 通过修改视图模板配置可生成多套视图模板
    ],
    'default' => [
        'label' => '更新',
        'controller' => sprintf('%s/%s%s', 'Backend', 'Upgrade', 'Controller'),
        'view' => join(',', [
            'create',
            'edit',
            'list',
        ]),
        'request' => join(',', [
            sprintf('%s/%s%s%s', 'Backend', 'Upgrade', 'Create', 'Request'),
            sprintf('%s/%s%s%s', 'Backend', 'Upgrade', 'Update', 'Request'),
        ]),
        'repository' => sprintf('%s/%s%s', 'Backend', 'Upgrade', 'Repository'),
        'model' => 'Upgrade',
    ],
];
