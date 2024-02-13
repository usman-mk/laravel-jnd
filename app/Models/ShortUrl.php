<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ShortUrl extends Model
{
    use HasFactory;

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'original_url',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            // create validate
            $validator = Validator::make($model->attributes, $model->storeRules());
            if ($validator->fails()) {
                $model->errors = $validator->errors();
                return false;
            }

            return true;
        });
        static::updating(function($model) {
            // create validate
            $validator = Validator::make($model->attributes, $model->updateRules());
            if ($validator->fails()) {
                $model->errors = $validator->errors();
                return false;
            }

            return true;
        });
    }

    public function storeRules()
    {
        return [
            'code' => ['required', Rule::unique((new self())->getTable())],
            'original_url' => 'required|string|url|max:200',
        ];
    }

    public function updateRules()
    {
        return [
            'code' => [
                'required',
                'string',
                Rule::unique((new self())->getTable())->ignore($this->getKey(), $this->getKeyName())
            ],
            'original_url' => 'required|string|url|max:200',
        ];
    }

    public function getKey()
    {
        return $this->code;
    }
}
