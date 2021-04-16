<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Promotions;
use App\Models\User;
use App\Models\Offer;
use DB;
use Auth;
use Illuminate\Support\Facades\Validator;

class Offers extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function offerList(Request $request)
    {
        //if ($request->isMethod('post')) {
        $page = request()->page;
        $promotion = DB::table('offer')->orderBy('OFFER_ID', 'desc');
        // dd($promotion);
        $promodata = $promotion->simplePaginate(1000, ['*'], 'page', $page);
        $params = $request->all();
        $params['page'] = $page;
        return view('offerList', ['promodata' => $promodata, 'params' => $params]);
        // } else {
        //     return view('offerList');
        // }
    }

    public function createOffer(Request $request)
    {

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(),  [
                //'userId' => 'required|max:10',
                'offer_type' => 'required|max:100',
                'offer_cat' => 'required|max:200',
                'offer_name' => 'required',
                'offer_details' => 'required',
                'offer_steps' => 'required|max:1000',
                'offer_banner' => 'required|max:2048',
                'offer_url' => 'required',
                'offer_os' => 'required',
                'offer_origin' => 'required||max:100',
                'offer_cap' => 'required|max:200',
                'fall_url' => 'required',
                'start_from' => 'required',
                'ends_on' => 'required',
                'status' => 'required',
                'offer_app' => 'required',
                //'offer_steps' => 'required',
            ]);
            $params = $request->all();
            if ($validator->fails()) {
                return redirect('createOffer')
                    ->withErrors($validator)
                    ->withInput();
            }
            $imageName = time() . '.' . $request->offer_banner->extension();
            $request->offer_banner->move(public_path('images'), $imageName);
            $offerSteps = json_encode($request->offer_steps);
            $path =  $imageName;
            $creteOffer = Offer::create([
                'OFFER_TYPE' => $request->offer_type,
                'OFFER_CATEGORY' => $request->offer_cat,
                'OFFER_NAME' => $request->offer_name,
                'OFFER_DETAILS' => $request->offer_details,
                'OFFER_STEPS' => $offerSteps,
                'OFFER_THUMBNAIL' => $request->offer_type,
                'OFFER_BANNER' => $path,
                'OFFER_URL' => $request->offer_url,
                'OFFER_OS' => $request->offer_os,
                'OFFER_ORIGIN' => $request->offer_origin,
                'CAP' => $request->offer_cap,
                'FALLBACK_URL' => $request->fall_url,
                'STARTS_FROM' => $request->start_from,
                'ENDS_ON' => $request->ends_on,
                'STATUS' => $request->status,
                'OFFER_APP' => $request->offer_app,
                'CREATED_BY' => Auth::user()->name,
                'CREATED_AT' => date('Y-m-d H:i:s'),
            ]);

            if ($creteOffer) {
                return redirect()->back()->withSuccess('Successfully Created !');
            } else {
                return view('createOffer');
            }
            
        } else {
            return view('createOffer');
        }
    }
}
