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
                'offer_type' => 'required',
                'offer_dis_type' => 'required',
                'offer_cat' => 'required',
                'offer_name' => 'required',
                'offer_details' => 'required',
                'offer_amount' => 'required',
                'offer_package' => 'required',
                'offer_steps' => 'required',
                // 'offer_thumb' => 'required',
                // 'offer_banner' => 'required',
                'offer_url' => 'required',
                'offer_os' => 'required',
                'offer_origin' => 'required',
                'offer_cap' => 'required',
                'fall_url' => 'required',
                'start_from' => 'required',
                'ends_on' => 'required',
                'status' => 'required',
                'offer_app' => 'required',
                'offer_ins' => 'required',
            ]);

            if ($validator->fails()) {
                if (!empty($request->editType) && !empty($request->offerId) && $request->editType == "edit") {
                    return redirect()->to('createOffer?type=edit&offerId=' . $request->offerId . '')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    return redirect('createOffer')
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            $offerSteps = $request->offer_steps;
            $sub_key = 'offerSteps';
            $new_Steps_array = [];
            foreach ($offerSteps as $value) {
                $new_Steps_array[] = [$sub_key => $value];
            }

            if (!empty($request->offer_banner)) {
                $imageName = time() . 'banner.' . $request->offer_banner->extension();
                $request->offer_banner->move(public_path('images/banner'), $imageName);
                $path =  $imageName;
            }
            if (!empty($request->offer_thumb)) {
                $imageTumbName = time() . 'thumb.' . $request->offer_thumb->extension();
                $request->offer_thumb->move(public_path('images/thumb'), $imageTumbName);
                $tumbPath =  $imageTumbName;
            }
            if (!empty($request->editType) && $request->editType == "edit") {
                $offerData = DB::table('offer')->where('OFFER_ID', $request->offerId)->orderBy('OFFER_ID', 'desc')->first();
                if(empty($path)){
                    $path = $offerData->OFFER_BANNER;
                }
                if(empty($tumbPath)){
                    $tumbPath = $offerData->OFFER_THUMBNAIL;
                }
                $offerData = [
                    'OFFER_TYPE' => $request->offer_type,
                    'OFFER_DISPLAY_TYPE' => $request->offer_dis_type,
                    'OFFER_CATEGORY' => $request->offer_cat,
                    'OFFER_NAME' => $request->offer_name,
                    'OFFER_DETAILS' => $request->offer_details,
                    'OFFER_AMOUNT' => $request->offer_amount,
                    'OFFER_PACKAGE' => $request->offer_package,
                    'OFFER_STEPS' => json_encode($new_Steps_array),
                    'OFFER_THUMBNAIL' => $tumbPath ?? "",
                    'OFFER_BANNER' => $path ?? "",
                    'OFFER_URL' => $request->offer_url,
                    'OFFER_OS' => $request->offer_os,
                    'OFFER_ORIGIN' => $request->offer_origin,
                    'CAP' => $request->offer_cap,
                    'FALLBACK_URL' => $request->fall_url,
                    'OFFER_INSTRUCTIONS' => $request->offer_ins,
                    'STARTS_FROM' => $request->start_from,
                    'ENDS_ON' => $request->ends_on,
                    'STATUS' => $request->status,
                    'OFFER_APP' => $request->offer_app,
                    'CREATED_BY' => Auth::user()->name,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                ];
            } else {
                $offerData = [
                    'OFFER_TYPE' => $request->offer_type,
                    'OFFER_DISPLAY_TYPE' => $request->offer_dis_type,
                    'OFFER_CATEGORY' => $request->offer_cat,
                    'OFFER_NAME' => $request->offer_name,
                    'OFFER_DETAILS' => $request->offer_details,
                    'OFFER_AMOUNT' => $request->offer_amount,
                    'OFFER_PACKAGE' => $request->offer_package,
                    'OFFER_STEPS' => json_encode($new_Steps_array),
                    'OFFER_THUMBNAIL' => $tumbPath ?? "",
                    'OFFER_BANNER' => $path ?? "",
                    'OFFER_URL' => $request->offer_url,
                    'OFFER_OS' => $request->offer_os,
                    'OFFER_ORIGIN' => $request->offer_origin,
                    'CAP' => $request->offer_cap,
                    'FALLBACK_URL' => $request->fall_url,
                    'OFFER_INSTRUCTIONS' => $request->offer_ins,
                    'STARTS_FROM' => $request->start_from,
                    'ENDS_ON' => $request->ends_on,
                    'STATUS' => $request->status,
                    'OFFER_APP' => $request->offer_app,
                    'CREATED_BY' => Auth::user()->name,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                ];
            }

            
            if (empty($request->editType)) {
                $creteOffer = Offer::create($offerData);
                if ($creteOffer) {
                    return redirect()->back()->withSuccess('Successfully Created !');
                } else {
                    return view('createOffer');
                }
            } elseif (!empty($request->editType) && !empty($request->offerId) && $request->editType == "edit") { //edit section
                $updateOffer = Offer::where('OFFER_ID', $request->offerId)->update($offerData);
                if ($updateOffer) {
                    return redirect()->back()->withSuccess('Successfully Update !');
                } else {
                    return view('createOffer');
                }
            }
        } else {
            if (!empty($request->type) && $request->type == "edit") {
                $offerData = DB::table('offer')->where('OFFER_ID', $request->offerId)->orderBy('OFFER_ID', 'desc')->first();
                return view('createOffer', ['offerData' => $offerData, 'type' => $request->type]);
            } else {
                return view('createOffer');
            }
        }
    }


    public function updateOfferStatus(Request $request){
        $offerData = DB::table('offer')->where('OFFER_ID', $request->offer_id)->orderBy('OFFER_ID', 'desc')->first();
        if($offerData->STATUS==1){
            $status=2;
        }else if($offerData->STATUS==2){
            $status=1;
        }else{
            $status=3;
        }
        
        $updateOffer = Offer::where('OFFER_ID', $request->offer_id)->update(['STATUS' =>$status]);
        return $updateOffer;
    }
}
