<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Imports\BodpodImport;
use App\Events\FinishedImportBodpodResults;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Events\BodpodImportFailed;

class ImportBodpod implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $fileId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $fileId)
    {
        $this->user = $user;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        Excel::import(new BodpodImport($this->user), $this->fileId, 'do');
        if (Storage::disk('do')->exists($this->fileId)) {
            Storage::disk('do')->delete($this->fileId);
            event(new FinishedImportBodpodResults($this->user));
        }        
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        if (Storage::disk('do')->exists($this->fileId)) {
            Storage::disk('do')->delete($this->fileId);
            return event(new BodpodImportFailed($this->user));
        }   
        
    }
}
