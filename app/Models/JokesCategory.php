<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JokesCategory extends Model
{
    use HasFactory;

    protected $table = "joke_category";
    public $timestamps = FALSE;

    protected $fillable = [
        'CATEGORY_NAME','STATUS','CAT_IMAGE'
    ];
}
