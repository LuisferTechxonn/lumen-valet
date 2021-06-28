<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use  HasFactory , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'author','pages'
    ];

    protected $table = "books";

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    /*
     protected $hidden = [
        'password',
    ];
    */
}
