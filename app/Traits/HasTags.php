<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTags
{
    public function tags(): BelongsToMany
    {
        return $this->morphToMany(Tag::class, 'model','model_has_tags','model_id')->with(['uri:linkable_id,final_uri']);
    }

}
