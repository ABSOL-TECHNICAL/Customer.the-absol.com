<?php

namespace App\Jobs;

use App\Models\CustomerSites;
use App\Helpers\VendorApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateCustomerjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    
    protected $site;
    public $success = false; 

    /**
     * Create a new job instance.
     */
    public function __construct(CustomerSites $site)
    {
        $this->site = $site;
    }

   
    public function handle()
    {
        try {
            $result = VendorApi::create($this->site);
            if ($result) {
                $this->success = true;
                Log::info('Vendor API create method succeeded for site ID: ' . $this->site->id);
            } else {
                Log::warning('Vendor API create method failed for site ID: ' . $this->site->id);
            }
        } catch (\Throwable $th) {
            Log::error('Vendor API create method error for site ID ' . $this->site->id . ': ' . $th->getMessage());
            $this->success = false;
        }
    }
}
