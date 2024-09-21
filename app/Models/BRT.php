<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BRT extends Model
{
    use HasFactory;
    
    protected $table = 'brts';
    protected $fillable = ['user_id', 'brt_code', 'reserved_amount', 'status'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->brt_code = Str::uuid();
        });
    }
}