<?php

namespace App\Traits;

use App\Models\Taxonomy;

trait HasTaxonomy
{

    protected static function bootHasTaxonomy()
    {
        static::created(function ($content) {

            $new_taxonomy = $content->slug;
            $counter = 1;

            while (!Taxonomy::isUnique($new_taxonomy)) {
                $new_taxonomy = $content->slug . '-' . $counter;
                $counter++;
            }

            $taxonomy = new Taxonomy();
            $taxonomy->name = $new_taxonomy;
            $taxonomy->language = $content->language;
            $content->taxonomy()->save($taxonomy);

        });

        static::forceDeleted(function ($content) {
            if ($content->taxonomy) {
                $content->taxonomy()->delete();
            }
        });
    }


    public function taxonomy()
    {
        return $this->morphOne(Taxonomy::class, 'model');
    }

}
