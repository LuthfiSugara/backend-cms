<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];
}
