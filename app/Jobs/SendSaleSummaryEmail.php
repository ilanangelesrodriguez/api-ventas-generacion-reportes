<?php

namespace App\Jobs;

use App\Mail\SaleSummaryMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSaleSummaryEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $customerEmail;
    protected $saleDetails;
    /**
     * Create a new job instance.
     */
    public function __construct($customerEmail, $saleDetails)
    {
        $this->customerEmail = $customerEmail;
        $this->saleDetails = $saleDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->customerEmail)->send(new SaleSummaryMail($this->saleDetails));
    }
}
