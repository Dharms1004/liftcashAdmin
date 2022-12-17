<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourWinner extends Model
{
    use HasFactory;

    protected $table = "tr_winners";
    public $timestamps = FALSE;

    protected $fillable = [
        'TOUR_ID','TEAM_ID','RANK','PRIZE_MONEY','CREATED_BY','CREATED_ON'
    ];
}
