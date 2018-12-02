<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Group extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'members',
        'expenditures'
    ];

    public function getRouteKeyName()
    {
        return 'title';
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.M. Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.M. Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
