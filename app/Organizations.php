<?php

namespace App;
use App\Models\Auth\User;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\CourseTimeline;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class Organizations extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'organization_name',
        'phone',
        'email',
        'address',
        'specialization_field',
        ];

    protected $appends = ['image'];


    protected static function boot()
    {
        parent::boot();
        if (auth()->check()) {
            if (auth()->user()->hasRole('teacher')) {
                static::addGlobalScope('filter', function (Builder $builder) {
                    $builder->whereHas('teachers', function ($q) {
                        $q->where('organization_user.user_id', '=', auth()->user()->id);
                    });
                });
            }
        }

        static::deleting(function ($organization) { // before delete() method call this
            if ($organization->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $organization->organization_image))) {
                    File::delete(public_path('/storage/uploads/' . $organization->organization_image));
                    File::delete(public_path('/storage/uploads/thumb/' . $organization->organization_image));
                }
            }
        });


    }


    public function getImageAttribute()
    {
        if ($this->organization_image != null) {
            return url('storage/uploads/'.$this->organization_image);
        }
        return NULL;
    }

    public function getPriceAttribute()
    {
        if (($this->attributes['price'] == null)) {
            return round(0.00);
        }
        return $this->attributes['price'];
    }


    /**
     * Set attribute to money format
     * @param $input
     */
    public function setPriceAttribute($input)
    {
        $this->attributes['price'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'organization_user')->withPivot('user_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'organization_student')->withTimestamps()->withPivot(['rating']);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    public function publishedLessons()
    {
        return $this->hasMany(Lesson::class)->where('published', 1);
    }

    public function scopeOfTeacher($query)
    {
        if (!Auth::user()->isAdmin()) {
            return $query->whereHas('teachers', function ($q) {
                $q->where('user_id', Auth::user()->id);
            });
        }
        return $query;
    }

    public function getRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tests()
    {
        return $this->hasMany('App\Models\Test');
    }

    public function organizationTimeline()
    {
        return $this->hasMany(CourseTimeline::class);
    }

    public function getIsAddedToCart(){
        if(auth()->check() && (auth()->user()->hasRole('student')) && (\Cart::session(auth()->user()->id)->get( $this->id))){
            return true;
        }
        return false;
    }


    public function reviews()
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }

    public function progress()
    {
        $completed_lessons = \Auth::user()->chapters()->where('organization_id', $this->id)->get()->pluck('model_id')->toArray();
        if (count($completed_lessons) > 0) {
            return intval(count($completed_lessons) / $this->organizationTimeline->count() * 100);
        } else {
            return 0;
        }
    }

    public function isUserCertified()
    {
        $status = false;
        $certified = auth()->user()->certificates()->where('organization_id', '=', $this->id)->first();
        if ($certified != null) {
            $status = true;
        }
        return $status;
    }

    public function item()
    {
        return $this->morphMany(OrderItem::class, 'item');
    }

    public function bundles()
    {
        return $this->belongsToMany(Bundle::class, 'bundle_organizations');
    }

    public function chapterCount()
    {
        $timeline = $this->organizationTimeline;
        $chapters = 0;
        foreach ($timeline as $item) {
            if (isset($item->model) && ($item->model->published == 1)) {
                $chapters++;
            }
        }
        return $chapters;
    }

    public function mediaVideo()
    {
        $types = ['youtube', 'vimeo', 'upload', 'embed'];
        return $this->morphOne(Media::class, 'model')
            ->whereIn('type', $types);

    }

}
