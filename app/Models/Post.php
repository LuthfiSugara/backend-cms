<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'post';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'id_creator',
        'id_category',
        'slug',
        'content',
        'created_at',
        'updated_at',
    ];

    public function creator(){
        return $this->belongsTo(User::class, 'id_creator', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }
}
