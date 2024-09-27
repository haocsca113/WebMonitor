<?php

namespace App\Jobs;

use App\Models\Website;
use App\Models\AttackDetected;
use App\Http\Controllers\AttackDetectedController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AttackDetectedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $website;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Gọi controller để thực hiện giám sát SQL Injection
        $controller = new AttackDetectedController();
        $controller->attack_detected($this->website);
        \Log::info('Job running for website: ' . $this->website->url);
    }
}
