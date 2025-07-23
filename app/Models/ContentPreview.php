<?php

namespace App\Models;

use App\Traits\HasTags;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use App\Traits\WithoutAppends;
use App\Traits\HasLibraryMedia;
use App\Traits\HasSlugOriginal;
use Spatie\Sluggable\SlugOptions;
use App\Models\Scopes\LanguageScope;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentPreview extends Model implements Sortable
{
    use SoftDeletes, HasLibraryMedia, SortableTrait, HasSlug, HasSlugOriginal,HasTags, WithoutAppends;

    protected $fillable = [
        'uuid',
        'content_type_id',
        'language',
        'parent_id',
        'name',
        'summary',
        'slug',
        'slug_org',
        'additional',
        'is_published',
        'start_date',
        'end_date',
        'order_column',
        'content',
        'slider_id',
        'attributes',
        'layout_id',
        'header_layout_id',
        'users_only',
        'user_id',
        'read_count',
        'description',
        'created_at',
        'updated_at',
        'pivot_data',
        'depending_content_id'
    ];


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
        'additional' => 'array',
        'content' => 'array',
        'attributes' => 'array',
        'users_only' => 'boolean',
        'pivot_data' => 'array',
    ];

    protected static function booted()
    {        
        static::creating(function ($content) {
            if(!$content->uuid) {
                $content->uuid = Str::uuid();
            }
        });

    }

    protected $appends = ['child_nodes','media_objects','categories','seo'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function layout() {
        return $this->belongsTo(Layout::class,'layout_id', 'id');
    }

    public function header_layout() {
        return $this->belongsTo(HeaderLayout::class,'header_layout_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id')->withoutAppends()->select('id','name','uuid','language')->with('uri');
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->withoutAppends()->select('id','name','uuid','language')->with('uri');
    }

    //bu bagli oldugu
    public function depending_content()
    {
        return $this->belongsTo(self::class, 'depending_content_id', 'id')->withoutAppends()->select('id','name','uuid','language','attributes','depending_content_id')->with('uri:linkable_id,final_uri');
    }

    //bu sahip oldugu
    public function depending_contents()
    {
        return $this->hasMany(self::class, 'depending_content_id', 'id')->withoutAppends()->select('id','name','uuid','language','attributes','depending_content_id')->with(['uri:linkable_id,final_uri','main_image']);
    }

    public function content_categories(){

        return $this->belongsToMany(
            ContentCategory::class,
            'content_has_categories',
            'content_id',
            'category_id'
        )->withoutAppends()->select('id','name','language','uuid')->with(['uri:linkable_id,breadcrumb,final_uri']);

    }

    public function content_type(){

        return $this->belongsTo(ContentType::class)->withoutGlobalScope(LanguageScope::class);

    }

    public function slider(){

        return $this->belongsTo(Slider::class);

    }

    public function getCategoriesAttribute(){
        return $this->content_categories->toArray();
    }

    public function getSeoAttribute(){
        return $this->seo_data;
    }

    public function getMediaObjectsAttribute()
    {
        return [
            'mainImage' => $this->main_image->first(),
            'headerImage' => $this->header_image->first(),
            'mainVideo' => $this->main_video->first(),
            'headerVideo' => $this->header_video->first(),
            'galleryImages' => $this->gallery_images
        ];
    }


    public function createBreadCrumb(array $items_arr, $parent){

		$breadcrumb = $items_arr;
		
        if($parent){
            $item = array(
                'title' => $parent->name,
                'url' => '/'.$parent->uri->link
            );

            array_unshift($breadcrumb,$item);

            if( $parent->parent ){
                return $this->createBreadCrumb($breadcrumb,$parent->parent);
            }
        }

		return $breadcrumb;

	}
	public function getBreadCrumb(){
		
		return $this->createBreadCrumb(array(),$this->parent);

	}


    public function headIndex(){

        $heads = searchInArray($this->content,'type','title');

    }


}
