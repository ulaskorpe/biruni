<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Models\ContentAttribute;
use App\Models\ContentAttributeValue;
use App\Models\ContentType;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class FixUuids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-uuids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eski sistem link yapisini yeni yapiya geciriyoruz. Gerektiginde update icin de kullanilabilir.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $content_types = ContentType::withoutGlobalScopes()->get();
        $content_attributes = ContentAttribute::withoutGlobalScopes()->get();
        $content_attribute_values = ContentAttributeValue::withoutGlobalScopes()->get();
        $announcements = Announcement::withoutGlobalScopes()->get();

        foreach ($content_types as $key => $item) {
            
            if( !$item->uuid ){
                $item->update([
                    'uuid' => Str::uuid()
                ]);
            }

            if( empty($item->language) ){
                $item->update([
                    'language' => config('languages.default')
                ]);
            }

        }

        foreach ($content_attributes as $key => $item) {
            
            if( !$item->uuid ){
                $item->update([
                    'uuid' => Str::uuid()
                ]);
            }

            if( empty($item->language) ){
                $item->update([
                    'language' => config('languages.default')
                ]);
            }

        }

        foreach ($content_attribute_values as $key => $item) {
            
            if( !$item->uuid ){
                $item->update([
                    'uuid' => Str::uuid()
                ]);
            }

            if( empty($item->language) ){
                $item->update([
                    'language' => config('languages.default')
                ]);
            }

        }


        foreach ($announcements as $key => $item) {
            
            if( !$item->uuid ){
                $item->update([
                    'uuid' => Str::uuid()
                ]);
            }

            if( empty($item->language) ){
                $item->update([
                    'language' => config('languages.default')
                ]);
            }

        }

    }
}