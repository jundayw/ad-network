<?php

namespace App\Repositories\Render;

use App\Models\Adsense;
use App\Models\Element;
use App\Models\Material;
use App\Repositories\Repository;
use App\Services\Render\AdNetworkService;
use App\Services\Render\AdRenderService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AdsenseRepository extends Repository
{
    public function __construct(
        private readonly Adsense $adsense,
        private readonly Element $element,
        private readonly Material $material,
    )
    {
        //
    }

    /**
     * 获取流量主广告位信息
     *
     * @param Request $request
     * @return Adsense
     */
    private function getAdsense(Request $request): Adsense
    {
        $adsense = $this->adsense->with([
            'size' => function ($query) {
                $query->select([
                    'id', 'width', 'height', 'device', 'type',
                ]);
            },
        ])->where([
            'publishment_id' => $request->get('data-ad-client', 0),
            'state' => 'NORMAL',
        ])->find($request->get('data-ad-slot', 0));

        if (is_null($adsense)) {
            $adsense = $this->adsense;
        }

        return $adsense;
    }

    /**
     * 广告位
     *
     * @param Request $request
     * @return AdNetworkService
     */
    public function network(Request $request): AdNetworkService
    {
        $data = $request->all();

        $client = $request->get('data-ad-client', 0);
        $slot   = $request->get('data-ad-slot', 0);

        $adsense        = $this->getAdsense($request);
        $width          = $adsense->size->getAttribute('width');
        $height         = $adsense->size->getAttribute('height');
        $width          = $request->get('width', $request->get('data-ad-width', $width));
        $height         = $request->get('height', $request->get('data-ad-height', $height));
        $data['pid']    = $adsense->getAttribute('publishment_id');
        $data['sid']    = $adsense->getAttribute('size_id');
        $data['aid']    = $adsense->getAttribute('id');
        $data['origin'] = $adsense->getAttribute('origin');
        $data['device'] = $adsense->getAttribute('device');
        $data['type']   = $adsense->getAttribute('type');
        $data['vacant'] = $adsense->getAttribute('vacant');
        $data['width']  = $width;
        $data['height'] = $height;
        $data['st']     = get_timestamp(true);
        $data['ne']     = sprintf('u_%s', password($client, $slot));

        if ($adsense->getAttribute('type') == 'couplet') {
            $data['data-ad-couplet-top']   = $request->get('data-ad-couplet-top', 100);
            $data['data-ad-couplet-right'] = $request->get('data-ad-couplet-right', 0);
            $data['data-ad-couplet-left']  = $request->get('data-ad-couplet-left', 0);
        }

        if ($adsense->getAttribute('type') == 'float') {
            $data['data-ad-float-top']    = $request->get('data-ad-float-top', 0);
            $data['data-ad-float-right']  = $request->get('data-ad-float-right', 0);
            $data['data-ad-float-bottom'] = $request->get('data-ad-float-bottom', 0);
            $data['data-ad-float-left']   = $request->get('data-ad-float-left', 0);
        }

        $url = url()->signedRoute('render.adsense.render', $data);

        $view = match ($adsense->getAttribute('type')) {
            'popup' => 'render.adsense.network.popup',
            'float' => 'render.adsense.network.float',
            'couplet' => 'render.adsense.network.couplet',
            default => 'render.adsense.network.default'
        };

        return new AdNetworkService($view, compact('data', 'url', 'request'), $url, $request);
    }

    /**
     * 获取广告位
     *
     * @param Request $request
     * @return Adsense|null
     */
    protected function getRenderAdsense(Request $request): ?Adsense
    {
        return $this->adsense->where([
            'publishment_id' => $request->get('pid', 0),
            'size_id' => $request->get('sid', 0),
            'state' => 'NORMAL',
        ])->find($request->get('aid', 0));
    }

    /**
     * 广告位无效:广告代码无效
     *
     * @param Request $request
     * @return AdRenderService
     */
    public function getRenderAdsenseUnAvailable(Request $request): AdRenderService
    {
        return new AdRenderService('render.adsense.vacant.hidden', compact('request'));
    }

    /**
     * 获取广告物料
     *
     * @param Request $request
     * @param Adsense $adsense
     * @return Collection
     */
    protected function getRenderElement(Request $request, Adsense $adsense): Collection
    {
        // 1.广告主：账户余额足够
        // 2.推广计划：投放设备匹配且物料可用
        // 3.推广计划：当日限额可用
        // 4.推广创意：广告尺寸可用
        // 5.推广单元：符合流量主广告位计费方式
        // 6.推广单元：投放日期及时间段可用
        // 7.推广单元：价格优先
        return $this->element->whereHas('advertisements', function ($query) {
            $query->where('balance', '>', 1e4 * 5);
        })->whereHas('program', function ($query) use ($request) {
            $query->where([
                'device' => $request->get('device'),
                'state' => 'NORMAL',
            ])->where(function ($query) {
                $query->where(function ($query) {
                    $query->where([
                        'expire' => get_time('Y-m-d'),
                    ])->whereRaw('`charge` < `limit`');
                })->orWhere('expire', '<>', get_time('Y-m-d'))->orWhereNull('expire');
            });
        })->withWhereHas('creative', function ($query) use ($adsense) {
            $query->where([
                'size_id' => $adsense->getAttribute('size_id'),
                'state' => 'NORMAL',
            ]);
        })->unless($adsense->getAttribute('charging') == 'default', function ($query) use ($adsense) {
            $query->where([
                'type' => $adsense->getAttribute('charging'),
            ]);
        })->where([
            ['release_begin', '<=', get_time()],
            ['release_finish', '>=', get_time()],
        ])->whereTime('period_begin', '<=', get_time('H:i:s'))->whereTime('period_finish', '>=', get_time('H:i:s'))->where([
            'state' => 'NORMAL',
        ])->latest('rate')->take(5)->get();
    }

    /**
     * 广告位渲染异常:包括广告位下线及未匹配广告主物料
     *
     * @param Request $request
     * @return AdRenderService
     */
    public function getRenderUnAvailable(Request $request): AdRenderService
    {
        $unavailable = config('adnetwork.unavailable');
        return new AdRenderService('render.adsense.unavailable.index', compact('unavailable', 'request'));
    }

    /**
     * 无广告物料渲染空闲广告
     *
     * @param Request $request
     * @param Adsense $adsense
     * @return AdRenderService
     */
    protected function getRenderVacant(Request $request, Adsense $adsense): AdRenderService
    {
        // 显示换量广告
        if ($adsense->getAttribute('vacant') == 'exchange' && $exchange = $this->getRenderVacantForExchange($request, $adsense)) {
            return new AdRenderService('render.adsense.vacant.exchange', $exchange);
        }
        // 显示本地广告
        if ($adsense->getAttribute('vacant') == 'default' && $default = $this->getRenderVacantForDefault($request, $adsense)) {
            return new AdRenderService('render.adsense.vacant.default', $default);
        }
        // 显示联盟广告
        if ($adsense->getAttribute('vacant') == 'union' && $union = $this->getRenderVacantForUnion($request, $adsense)) {
            return new AdRenderService('render.adsense.vacant.union', $union);
        }
        // 固定占位符
        if ($adsense->getAttribute('vacant') == 'fixed' && $fixed = $this->getRenderVacantForFixed($request, $adsense)) {
            return new AdRenderService('render.adsense.vacant.fixed', $fixed);
        }
        // 隐藏广告位
        if ($adsense->getAttribute('vacant') == 'hidden') {
            return new AdRenderService('render.adsense.vacant.hidden', compact('request'));
        }
        // 广告位无效
        return $this->getRenderUnAvailable($request);
    }

    /**
     * 获取默认广告:未匹配的换量广告及固定占位符广告
     *
     * @param Request $request
     * @param Adsense $adsense
     * @param array $materials
     * @return array|null
     */
    private function getRenderVacantForMaterial(Request $request, Adsense $adsense, array $materials = []): ?array
    {
        $material = $this->material->whereIn('publishment_id', $materials)->where([
            'size_id' => $request->get('sid', 0),
            'device' => $adsense->getAttribute('device'),
            'state' => 'NORMAL',
        ])->inRandomOrder()->first();

        if (is_null($material)) {
            return null;
        }

        $material = [
            'location' => $material->getAttribute('location'),
            'image' => $material->getAttribute('image'),
            'callback' => 'test',
        ];

        return compact('material', 'request');
    }

    /**
     * 显示换量广告
     *
     * @param Request $request
     * @param Adsense $adsense
     * @return array|null
     */
    private function getRenderVacantForExchange(Request $request, Adsense $adsense): ?array
    {
        $materials = $this->material->whereHas('publishments', function ($query) {
            $query->where('weight', '>', '0');
        })->where([
            'publishment_id' => $request->get('pid', 0),
            'size_id' => $request->get('sid', 0),
            'device' => $adsense->getAttribute('device'),
            'state' => 'NORMAL',
        ])->get();
        if ($materials->isEmpty()) {
            return $this->getRenderVacantForMaterial($request, $adsense, config('adnetwork.vacant.exchange'));
        }
        $material = $materials->random();
        $material = [
            'location' => $material->getAttribute('location'),
            'image' => $material->getAttribute('image'),
            'callback' => 'test',
        ];
        return compact('material', 'request');
    }

    /**
     * 显示本地广告
     *
     * @param Request $request
     * @param Adsense $adsense
     * @return array
     */
    private function getRenderVacantForDefault(Request $request, Adsense $adsense): array
    {
        $local = [
            'location' => $adsense->getAttribute('locator'),
            'image' => $adsense->getAttribute('image'),
            'callback' => 'test',
        ];
        return compact('local', 'request');
    }

    /**
     * 显示联盟广告
     *
     * @param Request $request
     * @param Adsense $adsense
     * @return array
     */
    private function getRenderVacantForUnion(Request $request, Adsense $adsense): array
    {
        $code = $adsense->getAttribute('code');
        $code = str_ireplace(['alert', 'console', 'location', 'cookie', 'eval'], [''], $code);
        return compact('code', 'request');
    }

    /**
     * 显示固定占位符广告
     *
     * @param Request $request
     * @param Adsense $adsense
     * @return array|null
     */
    private function getRenderVacantForFixed(Request $request, Adsense $adsense): ?array
    {
        return $this->getRenderVacantForMaterial($request, $adsense, config('adnetwork.vacant.fixed'));
    }

    /**
     * 广告位展现类型
     *
     * @param Request $request
     * @param Adsense $adsense
     * @param Collection $elements
     * @return AdRenderService
     */
    protected function getRenderElementByAdsense(Request $request, Adsense $adsense, Collection $elements): AdRenderService
    {
        if (in_array($adsense->getAttribute('type'), ['multigraph'])) {
            return new AdRenderService('render.adsense.element.multigraph', $this->getRenderElementFromMultigraph($request, $adsense, $elements));
        }
        if (in_array($adsense->getAttribute('type'), ['single', 'popup', 'float', 'couplet'])) {
            return new AdRenderService('render.adsense.element.single', $this->getRenderElementFromSingle($request, $adsense, $elements));
        }
        return $this->getRenderUnAvailable($request);
    }

    /**
     * 展现类型:多图
     *
     * @param Request $request
     * @param Adsense $adsense
     * @param Collection $elements
     * @return array
     */
    private function getRenderElementFromMultigraph(Request $request, Adsense $adsense, Collection $elements): array
    {
        $multigraph = $elements->map(function (Element $element) {
            $creative = $element->getRelation('creative')->random();
            return [
                'location' => $creative->getAttribute('location'),
                'image' => $creative->getAttribute('image'),
                'callback' => 'test',
            ];
        });
        return compact('multigraph', 'request');
    }

    /**
     * 展现类型:单图
     *
     * @param Request $request
     * @param Adsense $adsense
     * @param Collection $elements
     * @return array
     */
    private function getRenderElementFromSingle(Request $request, Adsense $adsense, Collection $elements): array
    {
        $creative = $elements->random()->getRelation('creative')->random();
        $creative = [
            'location' => $creative->getAttribute('location'),
            'image' => $creative->getAttribute('image'),
            'callback' => 'test',
        ];
        return compact('creative', 'request');
    }

    /**
     * 广告渲染核心逻辑
     *
     * @param Request $request
     * @return AdRenderService
     */
    protected function getRender(Request $request): AdRenderService
    {
        // 获取广告位
        $adsense = $this->getRenderAdsense($request);
        // 广告位无效
        if (is_null($adsense)) {
            return $this->getRenderAdsenseUnAvailable($request);
        }
        // 获取广告主广告物料
        $elements = $this->getRenderElement($request, $adsense);
        // 无广告物料渲染空闲广告
        if ($elements->isEmpty()) {
            // 空闲设置类型：'exchange','default','union','fixed','hidden'
            return $this->getRenderVacant($request, $adsense);
        }
        // 广告位展现类型：'multigraph', 'single', 'popup', 'float', 'couplet'
        return $this->getRenderElementByAdsense($request, $adsense, $elements);
    }

    public function render(Request $request): AdRenderService
    {
        // 可以优化加个缓存，减轻对系统压力
        return $this->getRender($request);
    }
}
