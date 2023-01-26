<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Promotions;
use App\Models\Turnament;
use App\Models\TourTeam;
use App\Models\TourWinner;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;


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

    public function teamListRegistered(Request $request){
        $page = request()->page;

        $tourId = $request->tour_id;
        $team = DB::table('tr_tournament_registration as ttr')->select('ttt.*')->join('tr_tournament_team as ttt', 'ttr.TEAM_ID', '=', 'ttt.TEAM_ID')->where('ttr.TOUR_ID', $tourId)->orderBy('TEAM_ID', 'desc');
        $teamdata = $team->simplePaginate(1000, ['*'], 'page', $page);
        
        $params = $request->all();
        $params['page'] = $page;

        return view('teamListTourReg', ['teamdata' => $teamdata, 'params' => $params]);
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
            $rules = json_encode($request->tour_rules,JSON_FORCE_OBJECT);
            
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
                    'ORG_NAME' => $request->org_name,
                    'ORG_CONTACT' => $request->org_contact,
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
                    'TOUR_RULES' => $rules,
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
                    'ORG_NAME' => $request->org_name,
                    'ORG_CONTACT' => $request->org_contact,
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
                    'TOUR_RULES' => $rules,
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


    public function announceWinner(Request $request){

        $finishedTournaments = Turnament::select('TOUR_ID', 'TOUR_NAME')->where('TOUR_END_TIME', "<", date('Y-m-d H:i:s'))->get();
        $tournamentTeams = TourTeam::select('TEAM_ID', 'TEAM_NAME')->where('TEAM_STATUS', 1)->get();
        $params = $request->all();

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(),  [
                'tournament_id' => 'required',
                'winner_one' => 'required',
                'winner_one_rank' => 'required',
                'winner_one_prize' => 'required',
                'winner_two' => 'required',
                'winner_two_rank' => 'required',
                'winner_two_prize' => 'required',
                'winner_three' => 'required',
                'winner_three_rank' => 'required',
                'winner_three_prize' => 'required',
            ]);
            
            if ($validator->fails()) {
                    return redirect('addWinner')
                        ->withErrors($validator)
                        ->withInput();
            }

            //winner one

            if (!empty($request->winner_one_logo)) {
                $imageName = time() . 'teamLogo.' . $request->winner_one_logo->extension();
                $request->winner_one_logo->move(public_path('images/team/logo'), $imageName);
                $winOneLogo =  $imageName;
            }

            if (!empty($request->winner_one_image)) {
                $bannerName = time() . 'teamImage.' . $request->winner_one_image->extension();
                $request->winner_one_image->move(public_path('images/team/image'), $bannerName);
                $winOneImage =  $bannerName;
            }

            //winner two 

            if (!empty($request->winner_two_logo)) {
                $imageName = time() . 'teamLogo.' . $request->winner_two_logo->extension();
                $request->winner_two_image->move(public_path('images/team/logo'), $imageName);
                $winTwoLogo =  $imageName;
            }

            if (!empty($request->winner_two_image)) {
                $bannerName = time() . 'teamImage.' . $request->winner_two_image->extension();
                $request->winner_two_image->move(public_path('images/team/image'), $bannerName);
                $winTwoImage =  $bannerName;
            }

            //winner three
            if (!empty($request->winner_three_logo)) {
                $imageName = time() . 'teamLogo.' . $request->winner_three_logo->extension();
                $request->winner_three_logo->move(public_path('images/team/logo'), $imageName);
                $winThreeLogo =  $imageName;
            }

            if (!empty($request->winner_three_image)) {
                $bannerName = time() . 'teamImage.' . $request->winner_three_image->extension();
                $request->winner_three_image->move(public_path('images/team/image'), $bannerName);
                $winThreeImage =  $bannerName;
            }
           
            $winnerData= [[
                'TOUR_ID' => $request->tournament_id,
                'TEAM_ID' => $request->winner_one,
                'RANK' => $request->winner_one_rank,
                'PRIZE_MONEY' => $request->winner_one_prize,
                'TEAM_LOGO' => $winOneLogo ?? "",
                'TEAM_IMAGE' => $winOneImage ?? "",
                'CREATED_BY' => Auth::user()->name,
                'CREATED_ON' => date('Y-m-d H:i:s')
            ],
            [
                'TOUR_ID' => $request->tournament_id,
                'TEAM_ID' => $request->winner_two,
                'RANK' => $request->winner_two_rank,
                'PRIZE_MONEY' => $request->winner_two_prize,
                'TEAM_LOGO' => $winTwoLogo ?? "",
                'TEAM_IMAGE' => $winTwoImage ?? "",
                'CREATED_BY' => Auth::user()->name,
                'CREATED_ON' => date('Y-m-d H:i:s')
            ],
            [
                'TOUR_ID' => $request->tournament_id,
                'TEAM_ID' => $request->winner_three,
                'RANK' => $request->winner_three_rank,
                'PRIZE_MONEY' => $request->winner_three_prize,
                'TEAM_LOGO' => $winThreeLogo ?? "",
                'TEAM_IMAGE' => $winThreeImage ?? "",
                'CREATED_BY' => Auth::user()->name,
                'CREATED_ON' => date('Y-m-d H:i:s')
            ]];
            
            foreach ($winnerData as  $value) {
                $winnereCreated = TourWinner::create($value);
            }

            if($winnereCreated){
                return redirect()->back()->withSuccess('Successfully Update !');
            } else {
                return view('winnerPage', ['tournamentList' => $finishedTournaments, 'tourTeamsList' => $tournamentTeams, 'params' => $params]);
            }
        }else{
            return view('winnerPage', ['tournamentList' => $finishedTournaments, 'tourTeamsList' => $tournamentTeams, 'params' => $params]);
        }


    }

    public function sendNotification(Request $request){

        
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(),  [
                'heading' => 'required',
                'message' => 'required',
                'tour_id' => 'required',
            ]);
            
            if ($validator->fails()) {
                return redirect('pushNotificationTour')
                    ->withErrors($validator)
                    ->withInput();
            }

            $token = DB::table('tr_tournament_registration as ttr')->join('tr_tournament_team as ttt', 'ttr.TEAM_ID', '=', 'ttt.TEAM_ID')->join('users as u', 'u.USER_ID', '=', 'ttt.USER_ID')->where('ttr.TOUR_ID', $request->tour_id)->whereNotNull('u.FCM_TOKEN')->pluck('u.FCM_TOKEN')->all();
            
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);
            $notificationBuilder = new PayloadNotificationBuilder($request->heading);
            $notificationBuilder->setBody($request->message)->setSound('default');
            
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['App' => 'Android']);
            
            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();
            $filteredTokens = array_filter($token);
            
            $downstreamResponse = FCM::sendTo($filteredTokens, $option, $notification, $data);
    
            $res['success'] = $downstreamResponse->numberSuccess();
            $res['failure'] = $downstreamResponse->numberFailure();
            $res['modificstion'] = $downstreamResponse->numberModification();
            
            if ($res['success']) {
                return redirect()->back()->withSuccess("Sent Successfully.");
            }else{
                // return view('pushNotification');
                return redirect()->back()->withErrors('Unable to send.');
            }


        }else {
            $tourData = DB::table('tr_tournament')->select('TOUR_ID', 'TOUR_NAME')->where('TOUR_ID', $request->tour_id)->orderBy('TOUR_ID', 'desc')->first();
            return view('pushNotificationTour', ['tourData' => $tourData]);
        }
    }

}
