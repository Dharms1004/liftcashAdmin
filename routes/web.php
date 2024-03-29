<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Offers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/newLayout', function () {
    return view('index');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('login');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/offerList', [App\Http\Controllers\Offers::class, 'offerList'])->name('offerList');
Route::get('/createOffer', [App\Http\Controllers\Offers::class, 'createOffer'])->name('createOffer');
Route::post('/createOffer', [App\Http\Controllers\Offers::class, 'createOffer'])->name('createOffer');
Route::post('/updateOfferStatus', [App\Http\Controllers\Offers::class, 'updateOfferStatus'])->name('updateOfferStatus');
Route::get('/withdraw-list', [App\Http\Controllers\Withdraw::class, 'withdrawList'])->name('withdraw-list');
Route::get('/convertOffer-list', [App\Http\Controllers\Offers::class, 'getConvertedOffers'])->name('convertOffer-list');
Route::post('/witdrawApprove', [App\Http\Controllers\Withdraw::class, 'witdrawApprove'])->name('updateOfferStatus');

Route::get('/user-list', [App\Http\Controllers\UserList::class, 'getAllUser'])->name('user-list');
Route::post('/getUserDetails', [App\Http\Controllers\UserList::class, 'getUserDetails'])->name('getUserDetails');

Route::get('/gameList', [App\Http\Controllers\Games::class, 'gameList'])->name('game-list');
Route::get('/createGame', [App\Http\Controllers\Games::class, 'createGame'])->name('createGame');
Route::post('/createGame', [App\Http\Controllers\Games::class, 'createGame'])->name('createGame');
Route::post('/updateGameStatus', [App\Http\Controllers\Games::class, 'updateGameStatus'])->name('updateGameStatus');
Route::post('/makeReccomendedGame', [App\Http\Controllers\Games::class, 'makeReccomendedGame'])->name('makeReccomendedGame');

Route::get('/videoList', [App\Http\Controllers\VideoListing::class, 'videoList'])->name('video-list');
Route::get('/createVideo', [App\Http\Controllers\VideoListing::class, 'createVideo'])->name('createVideo');
Route::post('/createVideo', [App\Http\Controllers\VideoListing::class, 'createVideo'])->name('createVideo');
Route::post('/updateVideoStatus', [App\Http\Controllers\VideoListing::class, 'updateVideoStatus'])->name('updateVideoStatus');

Route::get('/bannerList', [App\Http\Controllers\MiniBanner::class, 'bannerList'])->name('banner-list');
Route::get('/createBanner', [App\Http\Controllers\MiniBanner::class, 'createBanner'])->name('createBanner');
Route::post('/createBanner', [App\Http\Controllers\MiniBanner::class, 'createBanner'])->name('createBanner');
Route::post('/updateBannerStatus', [App\Http\Controllers\MiniBanner::class, 'updateBannerStatus'])->name('updateBannerStatus');

Route::get('/createPopup', [App\Http\Controllers\MiniBanner::class, 'createPopup'])->name('createPopup');
Route::post('/createPopup', [App\Http\Controllers\MiniBanner::class, 'createPopup'])->name('createPopup');

/**Manage Contest Module*/
    Route::get('/managecontest', [App\Http\Controllers\UserContestController::class, 'index'])->name('index');
    Route::post('/managecontest', [App\Http\Controllers\UserContestController::class, 'index'])->name('index');
    Route::get('managecontest/createcontest', [App\Http\Controllers\UserContestController::class, 'createcontest'])->name('createcontest');
    Route::post('managecontest/createcontest', [App\Http\Controllers\UserContestController::class, 'createcontest'])->name('createcontest');
    Route::get('managecontest/edit_contest/{id}', [App\Http\Controllers\UserContestController::class, 'edit_contest'])->name('edit_contest');
    Route::get('managecontest/update_contest/{id}', [App\Http\Controllers\UserContestController::class, 'update_contest'])->name('update_contest');
    Route::post('managecontest/update_contest/{id}', [App\Http\Controllers\UserContestController::class, 'update_contest'])->name('update_contest');
    Route::post('/getContestModelData', [App\Http\Controllers\UserContestController::class, 'getContestModelData'])->name('getContestModelData');
    Route::get('/updateStatus', [App\Http\Controllers\UserContestController::class, 'updateStatus'])->name('updateStatus');

    /** manage contest questions */
    Route::get('/manage-question', [App\Http\Controllers\ManageQuestionController::class, 'index'])->name('manage-question');
    Route::post('/manage-question', [App\Http\Controllers\ManageQuestionController::class, 'index'])->name('manage-question');
    Route::post('manage-question/create_questions', [App\Http\Controllers\ManageQuestionController::class, 'create_questions'])->name('create_questions');
    Route::get('manage-question/create_questions', [App\Http\Controllers\ManageQuestionController::class, 'create_questions'])->name('create_questions');
    Route::post('/getContestTitle', [App\Http\Controllers\ManageQuestionController::class, 'getContestTitle'])->name('getContestTitle');
    Route::post('/insert_ques', [App\Http\Controllers\ManageQuestionController::class, 'insert_ques'])->name('insert_ques');
    Route::post('/updateQuesStatus', [App\Http\Controllers\ManageQuestionController::class, 'updateQuesStatus'])->name('updateQuesStatus');
    Route::post('/getQuestionModelData', [App\Http\Controllers\ManageQuestionController::class, 'getQuestionModelData'])->name('getQuestionModelData');
    Route::post('/updatequestion', [App\Http\Controllers\ManageQuestionController::class, 'updatequestion'])->name('updatequestion');
    Route::match(array('GET', 'POST'), '/viewparticipants', [App\Http\Controllers\ManageQuestionController::class, 'viewparticipants'])->name('viewparticipants');
    Route::get('getExcelExport', [App\Http\Controllers\ManageQuestionController::class, 'getExcelExport'])->name('getExcelExport');

    Route::get('/sendNotification', [App\Http\Controllers\PushNotification::class, 'index'])->name('sendNotification');
    Route::post('/sendNotification', [App\Http\Controllers\PushNotification::class, 'index'])->name('sendNotification');

    Route::get('/balancePatch', [App\Http\Controllers\BalancePatch::class, 'index'])->name('balancePatch');
    Route::get('/diamondPatch', [App\Http\Controllers\DiamondPatch::class, 'index'])->name('diamondPatch');

    Route::get('/countryList', [App\Http\Controllers\Country::class, 'countryList'])->name('country-list');
    Route::get('/createCountry', [App\Http\Controllers\Country::class, 'createCountry'])->name('createCountry');
    Route::post('/createCountry', [App\Http\Controllers\Country::class, 'createCountry'])->name('createCountry');
    // Route::post('/createGame', [App\Http\Controllers\Games::class, 'createGame'])->name('createGame');
    Route::post('/updateCountryStatus', [App\Http\Controllers\Country::class, 'updateCountryStatus'])->name('updateCountryStatus');

    /** start added by Ashu */
    Route::get('/turnamentList', [App\Http\Controllers\Turnaments::class, 'turnamentList'])->name('turnament-list');
    Route::get('/teamList', [App\Http\Controllers\Turnaments::class, 'teamList'])->name('team-list');
    Route::get('/playerList', [App\Http\Controllers\Turnaments::class, 'playerList'])->name('player-list');
    Route::get('/registeredTeamList', [App\Http\Controllers\Turnaments::class, 'teamListRegistered'])->name('registered-Team-List');
    Route::get('/addWinner', [App\Http\Controllers\Turnaments::class, 'announceWinner'])->name('add-winners');
    Route::post('/addWinner', [App\Http\Controllers\Turnaments::class, 'announceWinner'])->name('add-winners');
    

    Route::get('/createTurnament', [App\Http\Controllers\Turnaments::class, 'createTurnament'])->name('createTurnament');
    Route::post('/createTurnament', [App\Http\Controllers\Turnaments::class, 'createTurnament'])->name('createTurnament');
    /** end added by Ashu */


    /**
     * Author : Dharminder Singh
     * Module : Send notification to tournament users
     * Date : 21/Jan/2023
     */
    Route::get('/sendNotificationTour', [App\Http\Controllers\Turnaments::class, 'sendNotification'])->name('sendNotificationTour');
    Route::post('/sendNotificationTour', [App\Http\Controllers\Turnaments::class, 'sendNotification'])->name('sendNotificationTour');

    Route::get('/addRoom', [App\Http\Controllers\Turnaments::class, 'addRoom'])->name('addRoom');
    Route::post('/addRoom', [App\Http\Controllers\Turnaments::class, 'addRoom'])->name('addRoom');

    /**
     * Author : Dharminder Singh
     * Module : Add Tournament Rules from excel file
     * Date : 27/Jan/2023
     */
    Route::get('/addTourRules', [App\Http\Controllers\Turnaments::class, 'addTournamentRules'])->name('addTourRules');
    Route::post('/addTourRules', [App\Http\Controllers\Turnaments::class, 'addTournamentRules'])->name('addTourRules');


    /**
     * Author : Dharminder Singh
     * Module : Adding jokes category and jokes
     * Date : 10/March/2023
     */
    Route::get('/addJoke', [App\Http\Controllers\Jokes::class, 'index'])->name('addJoke');
    Route::post('/addJoke', [App\Http\Controllers\Jokes::class, 'index'])->name('addJoke');
    Route::get('/jokesList', [App\Http\Controllers\Jokes::class, 'jokeList'])->name('joke-list');
    Route::post('/updateJokeStatus', [App\Http\Controllers\Jokes::class, 'updateJokeStatus'])->name('updateJokeStatus');


    Route::get('/addJokeCategory', [App\Http\Controllers\Jokes::class, 'addJokeCat'])->name('addJokeCategory');
    Route::post('/addJokeCategory', [App\Http\Controllers\Jokes::class, 'addJokeCat'])->name('addJokeCategory');
    Route::get('/jokesCatList', [App\Http\Controllers\Jokes::class, 'jokeListCat'])->name('joke-cat-list');
    Route::post('/updateJokeCatStatus', [App\Http\Controllers\Jokes::class, 'updateJokeCatStatus'])->name('updateJokeCatStatus');

        

    


