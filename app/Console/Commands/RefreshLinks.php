<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;

class RefreshLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-links';

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
        $links = Link::with(['linkable' => function($query){
            $query->withoutGlobalScopes();
        }])->get();

        foreach ($links as $key => $lin) {
            
            if( $lin->linkable && !$lin->final_uri ){

                $lin->final_uri = env('APP_URL').'/'.$lin->link;
                $lin->language = config('languages.default');
                $lin->save();

            }

        }

    }
}