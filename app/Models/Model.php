<?php

namespace App\Models;

use App\Custom\SoftDeletes;
use Auth;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use SoftDeletes;
    const DELETED_AT = 'is_deleted';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $casts = [
        'createdBy' => 'int',
        'updatedBy' => 'int',
        'is_deleted' => 'bool',
    ];

    public static $snakeCaseAttribute = false;

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ($model->from_mobile) {
                unset($model->from_mobile);
            } else {
                if (Auth::guard('web')->check()) {
                    $model->createdBy = Auth::id();
                }
            }
        });

        static::updating(function ($model) {
            if ($model->from_mobile) {
                unset($model->from_mobile);
            } else {
                if (Auth::guard('web')->check()) {
                    $model->updatedBy = Auth::id();
                    $model->updatedAt = date("Y-m-d H:i:s");
                }
            }
        });
    }
}
