<?php

namespace App\Jobs;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\Laravel\Facades\Image;

class OptimizeMediaWidthHeight implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Media $media;
    public function __construct($media)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if( $this->media->hasGeneratedConversion('op') ){

            $opImagePath = Str::replace([config('app-ea.app_url').'/','/'],['','\\'],$this->media->getUrl('op'));
            $imageOp = Image::read(public_path($opImagePath));
            $this->media->setCustomProperty('op_width',$imageOp->width());
            $this->media->setCustomProperty('op_height',$imageOp->height());
            $this->media->save();

        }

        
    }
}
