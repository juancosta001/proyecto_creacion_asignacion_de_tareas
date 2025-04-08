<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'estimated_end_date',
        'status',
        'client_id',
    ];
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }
}
{
    //
}
