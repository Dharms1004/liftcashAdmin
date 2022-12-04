<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Promotions;
use App\Models\Turnament;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;



class Turnaments extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function turnamentList(Request $request){
        $page = request()->page;
        $tournament = DB::table('tr_tournament')->orderBy('TOUR_ID', 'desc');
    
        $tournamentdata = $tournament->simplePaginate(1000, ['*'], 'page', $page);
        $params = $request->all();
        $params['page'] = $page;

        return view('turnamentList', ['tournamentdata' => $tournamentdata, 'params' => $params]);
    }

    public function teamList(Request $request){
        $page = request()->page;
        $team = DB::table('tr_tournament_team')->orderBy('TEAM_ID', 'desc');
    
        $teamdata = $team->simplePaginate(1000, ['*'], 'page', $page);
        $params = $request->all();
        $params['page'] = $page;

        return view('teamList', ['teamdata' => $teamdata, 'params' => $params]);
    }

    public function playerList(Request $request){
        $page = request()->page;
        $player = DB::table('tr_team_player')->orderBy('PLAYER_ID', 'desc');
    
        $playerdata = $player->simplePaginate(1000, ['*'], 'page', $page);
        $params = $request->all();
        $params['page'] = $page;

        return view('playerList', ['playerdata' => $playerdata, 'params' => $params]);
    }

    public function  createTurnament(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),  [
                'name' => 'required',
                'description' => 'required',
                'prize_money' => 'required',
            ]);
            
            if ($validator->fails()) {
                if (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") {
                    return redirect()->to('createTurnament?type=edit&id=' . $request->id . '')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    return redirect('createTurnament')
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            if (!empty($request->logo)) {
                $imageName = time() . 'tournamentLogo.' . $request->logo->extension();
                $request->logo->move(public_path('images/tournaments'), $imageName);
                $pathLogo =  $imageName;
            }

            if (!empty($request->banner)) {
                $bannerName = time() . 'tournamentBanner.' . $request->banner->extension();
                $request->banner->move(public_path('images/tournaments/banner'), $bannerName);
                $pathBanner =  $bannerName;
            }

            if (!empty($request->mini_banner)) {
                $miniBannerName = time() . 'tournamentMiniBanner.' . $request->mini_banner->extension();
                $request->mini_banner->move(public_path('images/tournaments/mini_banner'), $miniBannerName);
                $pathMiniBanner =  $miniBannerName;
            }

            if (!empty($request->editType) && $request->editType == "edit") {
                $tourData = DB::table('tr_tournament')->where('TOUR_ID', $request->id)->orderBy('TOUR_ID', 'desc')->first();

        
              if(empty($pathLogo)){
                     $pathLogo = $tourData->TOUR_LOGO;
                }

                if(empty($pathBanner)){
                    $pathBanner = $tourData->TOUR_BANNER;
               }

               if(empty($pathMiniBanner)){
                $pathMiniBanner = $tourData->TOUR_MINI_BANNER;
             }

                $tourData = [
                    'TOUR_NAME' => $request->name,
                    'TOUR_DESCRIPTION' => $request->description,
                    'TOUR_PRIZE_MONEY' => $request->prize_money,
                    'TOUR_PRIZE_TYPE' => $request->prize_type,
                    'TOUR_STATUS' => $request->status,
                    'TOUR_MAX_TEAM_ALLOWED' => $request->max_team_allowed,
                    'TOUR_MIN_TEAM_REQUIRED' => $request->min_team_required,
                    'TOUR_MAX_PLAYERS_ALLOWED' => $request->max_players_allowed,
                    'TOUR_MIN_PLAYERS_REQUIRED' => $request->min_players_required,
                    'TOUR_START_TIME' => $request->start_time,
                    'TOUR_END_TIME' => $request->end_time,
                    'TOUR_REGISTRATION_START_TIME' => $request->reg_start_time,

                  
                    'TOUR_LOGO' => $pathLogo ?? "",
                    'TOUR_BANNER' => $pathBanner ?? "",
                    'TOUR_MINI_BANNER' => $pathMiniBanner ?? "",

                    'TOUR_REGISTRATION_END_TIME' => $request->reg_end_time,
                    'CREATED_BY' => Auth::user()->name,
                    'UPDATED_BY' => Auth::user()->name,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                    'UPDATED_AT' => date('Y-m-d H:i:s'),
                ];
            } else {
                $tourData = [
                    'TOUR_NAME' => $request->name,
                    'TOUR_DESCRIPTION' => $request->description,
                    'TOUR_PRIZE_MONEY' => $request->prize_money,
                    'TOUR_PRIZE_TYPE' => $request->prize_type,
                    'TOUR_STATUS' => $request->status,
                    'TOUR_MAX_TEAM_ALLOWED' => $request->max_team_allowed,
                    'TOUR_MIN_TEAM_REQUIRED' => $request->min_team_required,
                    'TOUR_MAX_PLAYERS_ALLOWED' => $request->max_players_allowed,
                    'TOUR_MIN_PLAYERS_REQUIRED' => $request->min_players_required,
                    'TOUR_START_TIME' => $request->start_time,
                    'TOUR_END_TIME' => $request->end_time,
                    'TOUR_REGISTRATION_START_TIME' => $request->reg_start_time,


                   'TOUR_LOGO' => $pathLogo ?? "",
                   'TOUR_BANNER' => $pathBanner ?? "",
                   'TOUR_MINI_BANNER' => $pathMiniBanner ?? "",

                    'TOUR_REGISTRATION_END_TIME' => $request->reg_end_time,
                    'CREATED_BY' => Auth::user()->name,
                    'UPDATED_BY' => Auth::user()->name,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                    'UPDATED_AT' => date('Y-m-d H:i:s'),
                ];
            }


            if (empty($request->editType)) {
                $creteTour = Turnament::create($tourData);

                if ($creteTour) {
                    return redirect()->back()->withSuccess('Successfully Created !');
                } else {
                    return view('createTurnaments');
                }
            } elseif (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") { //edit section
                $updateTour = Turnament::where('TOUR_ID', $request->id)->update($tourData);
                if ($updateTour) {
                    return redirect()->back()->withSuccess('Successfully Update !');
                } else {
                    return view('createTurnaments');
                }
            }
        } else {
            if (!empty($request->type) && $request->type == "edit") {
                $tourData = DB::table('tr_tournament')->where('TOUR_ID', $request->id)->orderBy('TOUR_ID', 'desc')->first();
                return view('createTurnaments', ['tourData' => $tourData, 'type' => $request->type]);
            } else {
                return view('createTurnaments');
            }
        }
    }

    

    

    
}
