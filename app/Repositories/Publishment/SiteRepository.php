<?php

namespace App\Repositories\Publishment;

use App\Exceptions\RenderErrorResponseException;
use App\Models\Industry;
use App\Models\Site;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SiteRepository extends Repository
{
    public function __construct(
        private readonly Site $site,
        private readonly Industry $industry
    )
    {
        //
    }

    public function list(Request $request): array
    {
        $data = $this->site
            ->with([
                'industry',
            ])
            ->when($request->get('title'), function ($query) use ($request) {
                $query->where('title', 'LIKE', "%{$request->get('title')}%");
            })
            ->when($request->get('domain'), function ($query) use ($request) {
                $query->where('domain', 'LIKE', "%{$request->get('domain')}%");
            })
            ->when($request->get('industry'), function ($query) use ($request) {
                $query->where('industry_id', $request->get('industry'));
            })
            ->when($request->get('state'), function ($query) use ($request) {
                $query->where('state', $request->get('state'));
            })
            ->publishment($request)
            ->oldest('state')
            ->latest($this->site->getKeyName());

        $data = $data->Paginate($request->get('per', $this->site->getPerPage()), ['*'], 'page', $request->get('page', 1));

        $data->transform(function ($items) {
            $items->state   = $items->getState($items->state);
            $items->edit    = url()->signedRoute('publishment.site.edit', [$items->getKeyName() => $items->getKey()]);
            $items->destroy = url()->signedRoute('publishment.site.destroy', [$items->getKeyName() => $items->getKey()]);
            return $items;
        });

        $filter = [
            'industry' => $this->industry->oldest('sorting')->get(),
            'state' => $this->site->getState(),
        ];

        return compact('filter', 'data');
    }

    public function create(Request $request): array
    {
        $filter = [
            'industry' => $this->industry->oldest('sorting')->get(),
            'protocol' => $this->site->getProtocol(),
            'state' => $this->site->getState(),
        ];

        return compact('filter');
    }

    public function store(Request $request): array
    {
        $domain = $request->get('domain');
        $verify = password(strtoupper($domain), strtolower($domain));

        $collect                 = $request->request->all();
        $collect['domain']       = strtolower($domain);
        $collect['verify']       = $verify;
        $collect['verification'] = sprintf('ad-network-verification-%s', $verify);
        $collect['txt']          = sprintf('%s%s/%s.txt', $collect['protocol'], $collect['domain'], $collect['verification']);
        $collect['html']         = sprintf('%s%s', $collect['protocol'], $collect['domain']);

        session([$verify => $collect]);

        return compact('verify');
    }

    public function verify(Request $request): array
    {
        $filter = [
            'type' => $this->site->getType(),
        ];

        $data = session($request->get('verify'), [
            'verify' => 'verify',
            'verification' => 'verification',
            'txt' => 'txt',
            'html' => 'html',
        ]);

        return compact('filter', 'data');
    }

    public function verification(Request $request)
    {
        $type   = $request->get('type', 'txt');
        $verify = $request->get('verify', 'verify');

        $collect = collect(session($verify, []));

        $url = $collect->get($type);

        if (empty($url)) {
            throw new RenderErrorResponseException('验证类型无效');
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => sprintf('%s %s/%s', $request->userAgent(), 'AdNetwork', date('Y')),
            ])->get($url)->body();
        } catch (\Exception $exception) {
            throw new RenderErrorResponseException('网络请求异常');
        }

        if (!str_contains($response, $request->get('verify'))) {
            throw new RenderErrorResponseException('验证失败');
        }

        $count = $this->site->where([
            ['domain', $collect->get('domain')],
        ])->publishment($request)->first();

        if (!is_null($count)) {
            throw new RenderErrorResponseException('已存在');
        }

        $site = $this->site->create([
            'publishment_id' => $request->user()->getAttribute('publishment_id'),
            'industry_id' => $collect->get('industry'),
            'title' => $collect->get('title'),
            'protocol' => $collect->get('protocol'),
            'domain' => $collect->get('domain'),
            'hash' => $collect->get('verify'),
            'state' => $collect->get('state'),
        ]);

        if (is_null($site)) {
            throw new RenderErrorResponseException('新增失败');
        }

        return $site;
    }

    public function edit(Request $request): array
    {
        $data = $this->site->publishment($request)->find($request->get($this->site->getKeyName()));

        if (is_null($data)) {
            throw new RenderErrorResponseException('暂无记录');
        }

        $filter = [
            'industry' => $this->industry->oldest('sorting')->get(),
            'protocol' => $this->site->getProtocol(),
            'state' => $this->site->getState(),
        ];

        return compact('filter', 'data');
    }

    public function update(Request $request): bool
    {
        $site = $this->site->publishment($request)->find($request->get($this->site->getKeyName()));

        if (is_null($site)) {
            throw new RenderErrorResponseException('参数有误');
        }

        return $site->update([
            'industry_id' => $request->get('industry'),
            'title' => $request->get('title'),
            'protocol' => $request->get('protocol'),
            'description' => $request->get('description'),
            'state' => $request->get('state'),
        ]);
    }

    public function destroy(Request $request): bool
    {
        return !($this->site->publishment($request)->destroy($request->get($this->site->getKeyName())) === 0);
    }
}
