<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnament extends Model
{
    use HasFactory;

    protected $table = "tr_tournament";
    public $timestamps = FALSE;

    protected $fillable = [
        'TOUR_NAME','TOUR_DESCRIPTION','TOUR_PRIZE_MONEY','TOUR_PRIZE_TYPE','TOUR_STATUS','TOUR_MAX_TEAM_ALLOWED','TOUR_MIN_TEAM_REQUIRED','TOUR_MAX_PLAYERS_ALLOWED','TOUR_MIN_PLAYERS_REQUIRED','TOUR_LOGO','TOUR_BANNER','TOUR_MINI_BANNER','TOUR_START_TIME','TOUR_START_ENDTIME','TOUR_REGISTRATION_START_TIME','TOUR_REGISTRATION_START_ENDTIME','CREATED_BY','UPDATED_BY','CREATED_AT','UPDATED_AT'
    ];
}
