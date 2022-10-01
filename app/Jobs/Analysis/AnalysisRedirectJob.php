<?php

namespace App\Jobs\Analysis;

use App\Services\Analysis\AnalysisRedirectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalysisRedirectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param AnalysisRedirectService $redirectService
     * @return void
     */
    public function handle(AnalysisRedirectService $redirectService): void
    {
        echo $redirectService->run(collect($this->data));
    }
}
