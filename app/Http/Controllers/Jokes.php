<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Joke;
use App\Models\JokesCategory;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class Jokes extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $jokeCategory = DB::table('joke_category')->orderBy('CATEGORY_NAME', 'asc')->get();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),  [
                'joke_category' => 'required',
                'joke_title' => 'required',
                'joke' => 'required',
            ]);

            if ($validator->fails()) {
                if (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") {
                    return redirect()->to('addJokeCategory?type=edit&id=' . $request->id . '')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    return redirect('addJokeCategory')
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
                $jokesData = Joke::where('ID', $request->id)->first();

                if(empty($path)){
                    $path = $jokesData->image;
                }

                $jokeData = [
                    'JOKE_CAT' => $request->joke_category,
                    'JOKE_TITLE' => $request->joke_title,
                    'JOKE' => $request->joke,
                    'STATUS' => 1,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                ];
            } else {
                $jokeData = [
                    'JOKE_CAT' => $request->joke_category,
                    'JOKE_TITLE' => $request->joke_title,
                    'JOKE' => $request->joke,
                    'STATUS' => 1,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                ];
            }


            if (empty($request->editType)) {
                $creteJoke = Joke::create($jokeData);
                if ($creteJoke) {
                    return redirect()->back()->withSuccess('Joke added Successfully!');
                } else {
                    return view('jokes.jokes');
                }
            } elseif (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") { //edit section
                $updateJoke = Joke::where('ID', $request->id)->update($jokeData);
                if ($updateJoke) {
                    return redirect()->back()->withSuccess('Joke Successfully Updated!');
                } else {
                    return view('jokes.jokes');
                }
            }
        } else {
            if (!empty($request->type) && $request->type == "edit") {
                $jokeData = Joke::where('ID', $request->id)->first();
                return view('jokes.jokes', ['jokeCategory' => $jokeCategory, 'jokeData' => $jokeData ,'type' => $request->type]);
            } else {
                return view('jokes.jokes', ['jokeCategory' => $jokeCategory]);
            }
        }

    }

    public function jokeList(Request $request){
        $page = request()->page;
        $jokes = Joke::orderBy('ID', 'desc');
        $jokesdata = $jokes->simplePaginate(1000, ['*'], 'page', $page);
        $params = $request->all();
        $params['page'] = $page;

        return view('jokes.jokeList', ['jokesDatas' => $jokesdata, 'params' => $params]);
    }

    public function updateJokeStatus(Request $request){

        $jokeData = Joke::where('ID', $request->id)->orderBy('ID', 'desc')->first();
        if($jokeData->STATUS==1){
            $status=2;
        }else if($jokeData->STATUS==2){
            $status=1;
        }

        $updateOffer = Joke::where('ID', $request->id)->update(['STATUS' =>$status]);
        return $updateOffer;
    }

    public function addJokeCat(Request $request){
       
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),  [
                'jokeCat' => 'required'
            ]);

            if ($validator->fails()) {
                if (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") {
                    return redirect()->to('addJokeCategory?type=edit&id=' . $request->id . '')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    return redirect('addJokeCategory')
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            if (!empty($request->image)) {
                $imageName = time() . 'jokeCat.' . $request->image->extension();
                $request->image->move(public_path('images/jokes'), $imageName);
                $path =  $imageName;
            }

            if (!empty($request->editType) && $request->editType == "edit") {
                $jokesData = JokesCategory::where('ID', $request->id)->first();

                if(empty($path)){
                    $path = $jokesData->image;
                }

                $jokeData = [
                    'CATEGORY_NAME' => $request->jokeCat,
                    'CAT_IMAGE' => $path ?? "",
                    'STATUS' => 1,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                ];
            } else {
                $jokeData = [
                    'CATEGORY_NAME' => $request->jokeCat,
                    'CAT_IMAGE' => $path ?? "",
                    'STATUS' => 1,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                ];
            }

            if (empty($request->editType)) {
                $creteJoke = JokesCategory::create($jokeData);
                if ($creteJoke) {
                    return redirect()->back()->withSuccess('Joke added Successfully!');
                } else {
                    return view('jokes.jokesCategory');
                }
            } elseif (!empty($request->editType) && !empty($request->id) && $request->editType == "edit") { //edit section
                $updateJoke = JokesCategory::where('ID', $request->id)->update($jokeData);
                if ($updateJoke) {
                    return redirect()->back()->withSuccess('Joke Successfully Updated!');
                } else {
                    return view('jokes.jokesCategory');
                }
            }
        } else {
            if (!empty($request->type) && $request->type == "edit") {
                $jokeData = JokesCategory::where('ID', $request->id)->first();
                return view('jokes.jokesCategory', ['jokeData' => $jokeData, 'type' => $request->type]);
            } else {
                return view('jokes.jokesCategory');
            }
        }
    }

    public function jokeListCat(Request $request){
        $page = request()->page;
        $jokes = JokesCategory::orderBy('ID', 'desc');
        $jokesdata = $jokes->simplePaginate(1000, ['*'], 'page', $page);
        $params = $request->all();
        $params['page'] = $page;

        return view('jokes.jokeCatList', ['jokesDatas' => $jokesdata, 'params' => $params]);
    }

    public function updateJokeCatStatus(Request $request){

        $jokeCatData = JokesCategory::where('ID', $request->id)->orderBy('id', 'desc')->first();
        if($jokeCatData->STATUS==1){
            $status=2;
        }else if($jokeCatData->STATUS==2){
            $status=1;
        }

        $updateOffer = JokesCategory::where('ID', $request->id)->update(['STATUS' =>$status]);
        return $updateOffer;
    }


}
