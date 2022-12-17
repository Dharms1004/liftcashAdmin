<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourTeam extends Model
{
    use HasFactory;

    protected $table = "tr_tournament_team";
    public $timestamps = FALSE;

    protected $fillable = [
        'TOUR_ID','TEAM_ID','RANK','PRIZE_MONEY','CREATED_BY','CREATED_ON'
    ];
}
