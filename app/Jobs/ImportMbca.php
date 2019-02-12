<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MbcaImport;
use App\User;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Events\FinishedImportMbcaResults;
use App\Events\MbcaImportFailed;
use Illuminate\Support\Facades\Log;

class ImportMbca implements ShouldQueue
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
        Excel::import(new MbcaImport($this->user), $this->fileId, 'do',\Maatwebsite\Excel\Excel::CSV);
        if (Storage::disk('do')->exists($this->fileId)) {
            Storage::disk('do')->delete($this->fileId);
            event(new FinishedImportMbcaResults($this->user));
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
            return event(new MbcaImportFailed($this->user));
        }   
        
    }
}
