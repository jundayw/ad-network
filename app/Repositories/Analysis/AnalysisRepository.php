<?php

namespace App\Repositories\Analysis;

use App\Jobs\Analysis\AnalysisRedirectJob;
use App\Jobs\Analysis\AnalysisReviewJob;
use App\Models\Adsense;
use App\Models\Creative;
use App\Models\Material;
use App\Repositories\Repository;
use App\Services\Analysis\AnalysisRedirectService;
use App\Services\Analysis\AnalysisReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AnalysisRepository extends Repository
{
    public function __construct(
        private readonly Creative $creative,
        private readonly Adsense $adsense,
        private readonly Material $material,
        private readonly AnalysisReviewService $reviewService,
        private readonly AnalysisRedirectService $redirectService,
    )
    {
        //
    }

    public function review(Request $request): void
    {
        $data = array_merge($request->all(), [
            'ip' => $request->getClientIp(),
        ]);
        if (config('system.analysis_queue_ad', 'disable') == 'normal') {
            // 调度给队列处理图片展示统计
            AnalysisReviewJob::dispatch($data)->delay(now()->addSeconds(mt_rand(30, 60) / 15));
        } else {
            $this->reviewService->run(collect($data));
        }
    }

    public function redirect(Request $request): Collection
    {
        $data = array_merge($request->all(), [
            'ip' => $request->getClientIp(),
        ]);
        if (config('system.analysis_queue_location', 'disable') == 'normal') {
            // 调度给队列处理点击统计
            AnalysisRedirectJob::dispatch($data)->delay(now()->addSeconds(mt_rand(300, 360) / 500));
        } else {
            $this->redirectService->run(collect($data));
        }
        $path = match ($request->get('type')) {
            'single', 'multigraph', 'popup', 'float', 'couplet' => $this->element($request),
            'default', 'union' => $this->vacant($request),
            'exchange', 'fixed' => $this->material($request),
            default => config('system.unavailable_location')
        };
        return collect([
            'path' => $path,
            'headers' => [
                'origin-referer' => $request->get('lr'),
            ],
        ]);
    }

    private function element(Request $request)
    {
        $creative = $this->creative->find($request->get('cid'));

        if (is_null($creative)) {
            return null;
        }

        return $creative->getAttribute('location');
    }

    private function vacant(Request $request)
    {
        $adsense = $this->adsense->find($request->get('aid'));

        if (is_null($adsense)) {
            return null;
        }

        return $adsense->getAttribute('locator');
    }

    private function material(Request $request)
    {
        $material = $this->material->find($request->get('lid'));

        if (is_null($material)) {
            return null;
        }

        return $material->getAttribute('location');
    }
}
