<?php

namespace App\Traits;

use App\Models\Revision;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRevisions
{
    protected static function bootHasRevisions()
    {
        static::created(function ($content) {

            $requestData = request()->all();

            $revision = new Revision();
            $revision->json_data = $requestData;
            $revision->save();

            $content->revisions()->attach($revision->id);

        });

        static::updated(function ($content) {
            
            $requestData = request()->all();

            $content->revisions()->update([
                'is_active' => false
            ]);

            $revision = new Revision();
            $revision->json_data = $requestData;
            $revision->save();

            $content->revisions()->attach($revision->id);

        });

    }

    public function revisions(): BelongsToMany
    {
        return $this->morphToMany(Revision::class, 'model','model_has_revisions','model_id');
    }

}
