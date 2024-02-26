<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

/*Route::get('/', function () {
    return view('index');
})->name('index');*/

Route::get('/', 'App\Http\Controllers\LoginController@index');

Route::get('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');

Route::post('/login', 'App\Http\Controllers\LoginController@login')->name('login');

//  UTILISATEUR
/*Route::get('/calendrier', 'App\Http\Controllers\CalendrierController@calendrierUser')->name('calendrier');
Route::get('/resultat', 'App\Http\Controllers\ResultatController@resultatUser')->name('resultat');
Route::get('/total', 'App\Http\Controllers\DetailsController@tableauTotal')->name('total');
Route::get('/resultat/{idpays}/voirDetails', 'App\Http\Controllers\ResultatController@voirDetailMedailleUser')->name('voirDetailMedailleUser');
Route::get('/calendrier/pdf', 'App\Http\Controllers\CalendrierController@pdfGeneration')->name('genererPDF');*/

Route::middleware(['admin'])->group(function() {
    Route::get('/admin/accueil', function () {
        return view('admin.accueil');
    })->name('accueil');

//  PANNEAU
    Route::get('/admin/panneau/listepanneaux', 'App\Http\Controllers\PanneauController@listPanneau')->name('listePanneaux');
    Route::get('/admin/panneau/chargePanneau', function () {
        return view('admin.Panneau.insertPanneau');
    })->name('pageIP');
    Route::post('/admin/panneau/insertPanneau', 'App\Http\Controllers\PanneauController@insertPanneau')->name('insertPanneau');
    Route::put('/admin/panneau/{idPanneau}/update', 'App\Http\Controllers\PanneauController@updatePanneau');
    Route::delete('/admin/panneau/{idPanneau}/delete', 'App\Http\Controllers\PanneauController@deletePanneau');

    //    GROUPE
    Route::post('/admin/groupe/insertGroupe', 'App\Http\Controllers\GroupeController@insertGroupe')->name('insertGroupe');
    Route::get('/admin/groupe/chargeGroupe', function () {
        return view('admin.Groupe.inserteGroupe');
    })->name('Igroupe');
    Route::get('/admin/groupe/listeGroupe', 'App\Http\Controllers\GroupeController@listGroupe')->name('listeGroupe');
    Route::delete('/admin/groupe/{idgroupe}/delete', 'App\Http\Controllers\GroupeController@deleteGroupe')->name('deleteGroupe');
    Route::put('/admin/groupe/{idgroupe}/update', 'App\Http\Controllers\GroupeController@updateGroupe');

    //    JIRAMA
    Route::post('/admin/jirama/insertGroupe', 'App\Http\Controllers\JiramaController@insertJirama')->name('insertJirama');
    Route::get('/admin/jirama/chargeJirama', function () {
        return view('admin.Jirama.insertJirama');
    })->name('Igroupe');
    Route::get('/admin/jirama/listeJirama', 'App\Http\Controllers\JiramaController@listJirama')->name('listeJirama');
    Route::delete('/admin/jirama/{idjirama}/delete', 'App\Http\Controllers\JiramaController@deleteJirama')->name('deleteJirama');
    Route::put('/admin/jirama/{idjirama}/update', 'App\Http\Controllers\JiramaController@updateJirama');

    //    CONSOMMATION
    Route::post('/admin/consommation/insertConsommation', 'App\Http\Controllers\ConsommationController@insertConsommation')->name('insertConsommation');
    Route::get('/admin/consommation/chargeConsommation', function () {
        return view('admin.Consommation.insertConsommation');
    })->name('Iconso');
    Route::get('/admin/consommation/listeConsommation', 'App\Http\Controllers\ConsommationController@listConsommation')->name('listeConsommation');
    Route::delete('/admin/consommation/{idconsommation}/delete', 'App\Http\Controllers\ConsommationController@deleteConsommation')->name('deleteConsommation');
    Route::put('/admin/consommation/{idconsommation}/update', 'App\Http\Controllers\ConsommationController@updateConsommation');

    //      CSV
    Route::post('/admin/csv/insertCSV', 'App\Http\Controllers\DetailsController@importCSV')->name('importCSV');
    Route::get('/admin/csv', function () {
        return view('admin.importCSV');
    })->name('pageImport');

    //      DETAILS
    Route::get('/admin/details/detailsPC', 'App\Http\Controllers\DetailsController@getDetailsProdConso')->name('getDetailsProdConso');
    Route::get('/admin/details/detailsPP', 'App\Http\Controllers\DetailsController@getDetailsProdPrice')->name('getDetailsProdPrice');
    Route::get('/admin/details/graphique', 'App\Http\Controllers\DetailsController@getGraphProdConso')->name('getGraphProdConso');
    Route::get('/admin/details/{idp}/detailsP', 'App\Http\Controllers\DetailsController@getDetailsProd')->name('getDetailsProd');
    Route::get('/admin/details/{idp}/detailsC', 'App\Http\Controllers\DetailsController@getDetailsCons')->name('getDetailsCons');

    Route::get('/admin/details/pdf', 'App\Http\Controllers\DetailsController@pdfGeneration')->name('genererPDF');
    Route::get('/admin/details/csv', 'App\Http\Controllers\DetailsController@exportToCSV')->name('exportCSV');
    Route::get('/admin/details/csvprice', 'App\Http\Controllers\DetailsController@exportToCSVPrice')->name('exportCSVPrice');

    //      DELESTAGE
    Route::post('/admin/delestage/insertdelestage', 'App\Http\Controllers\DelestageController@insertDelestage')->name('insertDelestage');
    Route::get('/admin/delestage/chargeDelestage', function () {
        return view('admin.Delestage.insertDelestage');
    })->name('chargeDelestage');
    Route::get('/admin/delestage/listeDelestage', 'App\Http\Controllers\DelestageController@listDelestage')->name('listeDelestage');
    Route::delete('/admin/delestage/{iddelestage}/delete', 'App\Http\Controllers\DelestageController@deleteDelestage')->name('deleteDelestage');
    Route::put('/admin/delestage/{iddelestage}/update', 'App\Http\Controllers\DelestageController@updateDelestage');

    Route::post('/admin/delestage/insertAlea2', 'App\Http\Controllers\DelestageController@insertAlea2')->name('insertAlea2');
    Route::get('/admin/delestage/insertAlea2', function () {
        return view('admin.alea2');
    })->name('PIDelestage');

});


