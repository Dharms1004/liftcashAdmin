<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country as ModelsCountry;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Promotions;
use App\Models\Game;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class Country extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function countryList(Request $request){
        $page = request()->page;
        $country = DB::table('country')->orderBy('NAME');
        $countrydata = $country->simplePaginate(1000, ['*'], 'page', $page);
        $params = $request->all();
        $params['page'] = $page;

        return view('countryList', ['countrydata' => $countrydata, 'params' => $params]);
    }

    public function updateCountryStatus(Request $request){

        $gameData = DB::table('country')->where('ID', $request->id)->orderBy('ID', 'desc')->first();
        if($gameData->STATUS==1){
            $status=0;
        }else if($gameData->STATUS==0){
            $status=1;
        }

        $updateOffer = ModelsCountry::where('ID', $request->id)->update(['STATUS' =>$status]);
        return $updateOffer;
    }

    public function  createCountry(Request $request){
       
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),  [
                'name' => 'required',
                'FLAG' => 'required',
            ]);

            if ($validator->fails()) {
                if (!empty($request->editType) && !empty($request->ID) && $request->editType == "edit") {
                    return redirect()->to('createCountry?type=edit&id=' . $request->ID . '')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    return redirect('createCountry')
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            File::ensureDirectoryExists(public_path('images/country'));

            if (!empty($request->FLAG)) {
                $imageName = time() . 'country.' . $request->FLAG->extension();
                $request->FLAG->move(public_path('images/country'), $imageName);
                $path =  $imageName;
            }

            if (!empty($request->editType) && $request->editType == "edit") {
                $countryData = DB::table('country')->where('ID', $request->ID)->orderBy('ID', 'desc')->first();
                if(empty($path)){
                    $path = $countryData->FLAG;
                }

                $countryData = [
                    'NAME' => $request->name,
                    'FLAG' => $path ?? ""
                ];
            } else {
                $countryData = [
                    'NAME' => $request->name,
                    'FLAG' => $path ?? "",
                ];
            }


            if (empty($request->editType)) {
                $countryData = ModelsCountry::create($countryData);
                if ($countryData) {
                    return redirect()->back()->withSuccess('Successfully Created !');
                } else {
                    return view('createCountry');
                }
            } elseif (!empty($request->editType) && !empty($request->ID) && $request->editType == "edit") { //edit section
                // dd($request->ID);
                $countryData = ModelsCountry::where('ID', $request->ID)->update($countryData);
                if ($countryData) {
                    return redirect()->back()->withSuccess('Successfully Update !');
                } else {
                    return view('createCountry');
                }
            }
        } else {
            if (!empty($request->type) && $request->type == "edit") {
                $countryData = DB::table('country')->where('ID', $request->id)->orderBy('ID', 'desc')->first();
                return view('createCountry', ['countryData' => $countryData, 'type' => $request->type]);
            } else {
                return view('createCountry');
            }
        }
    }

    public function makeReccomendedGame(Request $request){

        $gameData = DB::table('games')->where('id', $request->id)->first();
        if($gameData->is_reccomended==1){
            $status=0;
        }else if($gameData->is_reccomended==0){
            $status=1;
        }

        $updateOffer = Game::where('id', $request->id)->update(['is_reccomended' =>$status]);
        return $updateOffer;
    }

    public function  createGame(Request $request){
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),  [
                'name' => 'required',
                // 'image' => 'required',
                'url' => 'required',
            ]);

            if ($validator->fails()) {
                if (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") {
                    return redirect()->to('createGame?type=edit&id=' . $request->id . '')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    return redirect('createGame')
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            if (!empty($request->image)) {
                $imageName = time() . 'game.' . $request->image->extension();
                $request->image->move(public_path('images/games'), $imageName);
                $path =  $imageName;
            }

            if (!empty($request->editType) && $request->editType == "edit") {
                $gameData = DB::table('games')->where('id', $request->id)->orderBy('id', 'desc')->first();

                if(empty($path)){
                    $path = $gameData->image;
                }

                $gameData = [
                    'name' => $request->name,
                    'image' => $path ?? "",
                    'url' => $request->url,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            } else {
                $gameData = [
                    'name' => $request->name,
                    'image' => $path ?? "",
                    'url' => $request->url,
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }


            if (empty($request->editType)) {
                $creteOffer = Game::create($gameData);
                if ($creteOffer) {
                    return redirect()->back()->withSuccess('Successfully Created !');
                } else {
                    return view('createGames');
                }
            } elseif (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") { //edit section
                $updateOffer = Game::where('id', $request->id)->update($gameData);
                if ($updateOffer) {
                    return redirect()->back()->withSuccess('Successfully Update !');
                } else {
                    return view('createGames');
                }
            }
        } else {
            if (!empty($request->type) && $request->type == "edit") {
                $gameData = DB::table('games')->where('id', $request->id)->orderBy('id', 'desc')->first();
                return view('createGames', ['gameData' => $gameData, 'type' => $request->type]);
            } else {
                return view('createGames');
            }
        }
    }
}
