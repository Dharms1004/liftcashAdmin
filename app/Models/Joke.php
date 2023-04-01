<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joke extends Model
{
    use HasFactory;

    protected $table = "jokes";
    public $timestamps = FALSE;

    protected $fillable = [
        'JOKE_CAT','JOKE_TITLE','JOKE','STATUS'
    ];
}
