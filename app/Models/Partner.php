<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['image'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {

        static::deleting(function ($partner) { // before delete() method call this
            if (File::exists(public_path('/storage/uploads/' . $partner->logo))) {
                File::delete(public_path('/storage/uploads/' . $partner->logo));
            }
        });
    }

    public function getImageAttribute()
    {
        if ($this->logo != null) {
            return url('storage/uploads/'.$this->logo);
        }
        return NULL;
    }

}
