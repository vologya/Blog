<?php

namespace App;

use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'slug'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->update(['slug' => $post->title]);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the author of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo( User::class, 'user_id' );
    }

    /**
     * Get the tags associated with the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany( Tag::class );
    }

    /**
     * Scope a query to only include filtered posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {
        if ( isset($filters['year']) ) {
            $query->whereYear('created_at', $filters['year']);
        }
        if ( isset($filters['month']) ) {
            $query->whereMonth('created_at', Carbon::parse($filters['month'])->month);
        }
        if ( isset($filters['tag']) ) {
            $query->whereIn(
                'id', 
                ($tag = Tag::whereName($filters['tag'])->first())
                    ? $tag->posts->pluck('id')
                    : []
            );
        }

        return $query;
    }

    /**
     * Set the slug when the title changes.
     *
     * @param string $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->update(['slug' => $value]);
    }

    /**
     * Set the proper slug attribute.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }

        $this->attributes['slug'] = $slug;
    }

}
