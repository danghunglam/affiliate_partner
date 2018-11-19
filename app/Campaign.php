<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Campaign extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'custom_url', 'campaign', 'source', 'medium', 'click', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function user(){
        return $this->belongsTo('App\User','user_id', 'id');
    }

    public function statistical(){
        return $this->hasMany('App\Statistical', 'campaign_id','id');
    }
}
