<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $data = [
            // 首页
            'url' => 'home.index',
            'name' => '广告联盟',
            'title' => '广告联盟',
            'keywords' => 'keywords',
            'description' => 'description',
            'logo' => 'assets/logo.png',
            'navigation' => [
                [
                    'title' => '首页',
                    'url' => 'home.index',
                ],
                [
                    'title' => '广告主',
                    'url' => 'advertisement.index',
                ],
                [
                    'title' => '网站主',
                    'url' => 'publishment.index',
                ],
                [
                    'title' => '演示',
                    'url' => [
                        'home.index', '/demo',
                    ],
                ],
            ],
            // slider
            'sliders' => [
                [
                    'background' => 'assets/3f4ca78567bdb98e942eeb371d07d475.png',
                    'title' => '精准投放 让您值得信赖的联盟',
                    'content' => [
                        '广告主是广告活动的发布者，是在网上销售或宣传自己产品和服务的商家，是联盟营销广告的提供者。',
                        '按照地域、时间等多种定向方式投放，实现广告精准投放。',
                    ],
                    'name' => '广告主平台',
                    'url' => 'advertisement.index',
                ],
                [
                    'background' => 'assets/7f55a27afd448a1a9ad41df1a5e0ff21.png',
                    'title' => '丰富多样的广告资源 完善的佣金结算系统',
                    'content' => [
                        '提供多种合作模式及广告模式，有效地保证广告的高点击率，帮助网站主的实现变现能力。',
                        '网站主可以采用多种灵活的方式获取收益，让您获得更多高额回报。',
                    ],
                    'name' => '网站主平台',
                    'url' => 'publishment.index',
                ],
            ],
            // 广告主
            'advertisement' => [
                'title' => '广告主入驻广告联盟流程',
                'content' => [
                    '进入注册页面，马上加盟',
                    '成为会员，后台充值',
                    '新建联盟推广计划，上传广告物料',
                    '随时进入后台查询推广效果',
                ],
                'name' => '广告主平台',
                'url' => 'advertisement.index',
                'image' => 'assets/20221013180433.png',
                'service' => [
                    'title' => '广告主平台优势',
                    'desc' => '广告主是广告活动的发布者，是在网上销售或宣传自己产品和服务的商家，是联盟营销广告的提供者。',
                    'list' => [
                        [
                            'icon' => 'fa fa-film',
                            'title' => '精准投放',
                            'content' => ['按照地域、时间等多种定向方式投放，实现广告精准投放。'],
                        ],
                        [
                            'icon' => 'fa fa-camera',
                            'title' => '反作弊及效果跟踪',
                            'content' => ['反作弊采用智能过滤拦截，针对各种异常数据进行过滤拦截。'],
                        ],
                        [
                            'icon' => 'fa fa-bullhorn',
                            'title' => '让您值得信赖的联盟',
                            'content' => ['为您提供详细数据报告，满足您的监控需求。'],
                        ],
                        [
                            'icon' => 'fa fa-music',
                            'title' => '强大的技术力量支持',
                            'content' => ['拥有独特的技术优势，强大的技术团队保证了系统的正常运行。'],
                        ],
                        [
                            'icon' => 'fa fa-magic',
                            'title' => '诚信为本',
                            'content' => ['诚信为本，做站长最值得信赖的网站广告联盟。'],
                        ],
                        [
                            'icon' => 'fa fa-bar-chart',
                            'title' => '全天候专业服务',
                            'content' => ['觉见技术问题提供专业的解决方案'],
                        ],
                    ],
                ],
            ],
            // 网站主
            'publishment' => [
                'title' => '网站主入驻广告联盟流程',
                'content' => [
                    '进入注册页面，马上加盟',
                    '成为会员，后台登记网址',
                    '领取广告代码，参与联盟推广计划',
                    '广告上线获取丰厚佣金，随时进入后台查询收益',
                ],
                'name' => '广告主平台',
                'url' => 'publishment.index',
                'image' => 'assets/20221013180501.png',
                'service' => [
                    'title' => '网站主平台优势',
                    'desc' => '提供多种合作模式及广告模式，有效地保证广告的高点击率，帮助网站主的实现变现能力。',
                    'list' => [
                        [
                            'icon' => 'fa fa-film',
                            'title' => '丰富多样的广告资源',
                            'content' => ['严格把控广告质量，确保最佳用户体验，提升站长的收入。'],
                        ],
                        [
                            'icon' => 'fa fa-camera',
                            'title' => '详细精准的数据统计',
                            'content' => ['为站长提供透明、实时的流量数据和收入报表，站长可随时监测。'],
                        ],
                        [
                            'icon' => 'fa fa-bullhorn',
                            'title' => '完善的佣金结算系统',
                            'content' => ['网站主可以采用多种灵活的方式获取收益，让您获得更多高额回报。'],
                        ],
                        [
                            'icon' => 'fa fa-music',
                            'title' => '强大的技术力量支持',
                            'content' => ['拥有独特的技术优势，强大的技术团队保证了系统的正常运行。'],
                        ],
                        [
                            'icon' => 'fa fa-magic',
                            'title' => '诚信为本',
                            'content' => ['诚信为本，做站长最值得信赖的网站广告联盟。'],
                        ],
                        [
                            'icon' => 'fa fa-bar-chart',
                            'title' => '全天候专业服务',
                            'content' => ['觉见技术问题提供专业的解决方案'],
                        ],
                    ],
                ],
            ],
            'faq' => [
                'title' => '常见问题',
                'desc' => '联盟常见问题及换量广告问题',
                'list' => [
                    [
                        'title' => '联盟支持哪些广告形式?',
                        'content' => '平台支持单图、多图、弹窗、悬浮、对联等广告形式。',
                    ],
                    [
                        'title' => '联盟支持哪些广告模式?',
                        'content' => '为站长提供CPC、CPM、CPV、CPA、CPS多种广告模式，大大提升了网站主的变现能力。',
                    ],
                    [
                        'title' => '联盟支持哪些投放设备?',
                        'content' => '平台支持PC及移动端等投放设备。',
                    ],
                    [
                        'title' => '什么是换量广告?',
                        'content' => '换量广告是联盟平台为网站主提供的一项创新广告形式，当广告位匹配不到合适的广告资源时，将展示换量广告资源。',
                    ],
                ],
            ],
        ];

        if (config('system.coming_soon_state', 'normal') == 'normal') {
            return redirect()->route('home.soon');
        }

        $data = config('system.home', []);

        if (!is_array($data)) {
            $data = json_decode($data, true);
        }

        return new ViewResponse($data, 'index');
    }

    public function soon(Request $request)
    {
        $data = [
            'name' => '广告联盟',
            'title' => '广告联盟',
            'keywords' => 'keywords',
            'description' => 'description',
            'logo' => 'assets/logo.png',
            'background' => 'assets/e218bb37a870cfde9d43cd8cd0379a32.png',
            'activist' => '稍后访问',
            'moment' => '系统升级',
            'date' => '2022-12-31 23:59:59',
            'location' => 'home.index',
        ];

        $data = config('system.coming_soon', []);

        if (!is_array($data)) {
            $data = json_decode($data, true);
        }

        return new ViewResponse($data, 'soon');
    }
}
