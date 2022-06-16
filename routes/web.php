<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('', 'HomeController@index');
Route::any('login', 'HomeController@login');
Route::any('logout', 'HomeController@logout');


Route::any('articoli', 'HomeController@articoli');
Route::any('modifica_articolo/{id}', 'HomeController@modifica_articolo');
//Route::any('nuovo_articolo', 'HomeController@nuovo_articolo');


Route::any('magazzino', 'HomeController@magazzino');


Route::any('ordini', 'HomeController@ordini');
Route::any('id_dotes/{id_dotes}', 'HomeController@id_dotes');
Route::any('magazzino/attivo', 'HomeController@attivo');
Route::any('magazzino/passivi', 'HomeController@passivi');
Route::any('magazzino/altri', 'HomeController@altri');
/*
Route::any('magazzino/produzione2/{cd_do}', 'HomeController@produzione2');
Route::any('magazzino/produzione2_tot/{cd_do}', 'HomeController@produzione2_tot');
Route::any('magazzino/produzione3/{id_dotes}/{id_fornitore}', 'HomeController@produzione3');
*/

Route::any('ajax/evadi_articolo2/{dorig}', 'AjaxController@evadi_articolo2');

Route::any('magazzino/carico', 'HomeController@carico_magazzino');
Route::any('magazzino/carico2/{cd_do}', 'HomeController@carico_magazzino2');
Route::any('magazzino/carico3/{id_fornitore}/{cd_do}', 'HomeController@carico_magazzino3');
Route::any('magazzino/carico3_tot/{id_fornitore}/{cd_do}', 'HomeController@carico_magazzino3_tot');
Route::any('magazzino/carico4/{id_fornitore}/{id_dotes}', 'HomeController@carico_magazzino4');
Route::any('magazzino/caricopks/{id_fornitore}/{id_dotes}', 'HomeController@carico_magazzino_pks');
Route::any('magazzino/carico00/{articolo}/{id_dotes}', 'HomeController@carico_magazzino00');
Route::any('magazzino/carico1/{cd_do}', 'HomeController@carico_magazzino1');
Route::any('magazzino/carico02/{cd_do}', 'HomeController@carico_magazzino02');
Route::any('magazzino/carico03/{id_fornitore}/{cd_do}', 'HomeController@carico_magazzino03');
Route::any('magazzino/carico03_tot/{id_fornitore}/{cd_do}', 'HomeController@carico_magazzino03_tot');
Route::any('magazzino/carico04/{id_fornitore}/{id_dotes}', 'HomeController@carico_magazzino04');

/*
Route::any('magazzino/trasporto_fornitore/{cd_do}', 'HomeController@trasporto_fornitore');
Route::any('magazzino/trasporto_documento/{cd_do}/{cd_cf}', 'HomeController@trasporto_documento');
Route::any('magazzino/trasporto_documento_tot/{cd_do}/{cd_cf}', 'HomeController@trasporto_documento_tot');
Route::any('magazzino/trasporto/{cd_do}/{cd_cf}/{Id_DoTes}', 'HomeController@trasporto_magazzino');
Route::any('magazzino/trasporto2/{cd_ar}/{cd_do}/{cd_cf}/{Id_DoTes}/{lotto}', 'HomeController@trasporto_magazzino2');
Route::any('magazzino/trasporto2_tot/{cd_ar}/{cd_do}/{cd_cf}/{Id_DoTes}/{lotto}', 'HomeController@trasporto_magazzino2_tot');
Route::any('magazzino/trasporto3/{cd_ar}/{cd_do}/{cd_cf}/{cd_mg}/{cd_mgubicazione}/{lotto}/{Id_DoTes}', 'HomeController@trasporto_magazzino3');
Route::any('magazzino/trasporto3_tot/{cd_ar}/{cd_do}/{cd_cf}/{cd_mg}/{cd_mgubicazione}/{lotto}/{Id_DoTes}', 'HomeController@trasporto_magazzino3_tot');
Route::any('magazzino/trasporto4/{cd_do}/{cd_cf}/{cd_mg}/{cd_mg_A}/{Id_DoTes}', 'HomeController@trasporto_magazzino4');

Route::any('magazzino/scarico', 'HomeController@scarico_magazzino');
Route::any('magazzino/scarico2/{cd_do}', 'HomeController@scarico_magazzino2');
Route::any('magazzino/scarico3/{id_fornitore}/{cd_do}', 'HomeController@scarico_magazzino3');
Route::any('magazzino/scarico3_tot/{id_fornitore}/{cd_do}', 'HomeController@scarico_magazzino3_tot');
Route::any('magazzino/scarico4/{id_fornitore}/{id_dotes}', 'HomeController@scarico_magazzino4');
Route::any('magazzino/scarico1', 'HomeController@scarico_magazzino1');
Route::any('magazzino/scarico02/{cd_do}', 'HomeController@scarico_magazzino02');
Route::any('magazzino/scarico03/{id_fornitore}/{cd_do}', 'HomeController@scarico_magazzino03');
Route::any('magazzino/scarico03_tot/{id_fornitore}/{cd_do}', 'HomeController@scarico_magazzino03_tot');
Route::any('magazzino/scarico04/{id_fornitore}/{id_dotes}', 'HomeController@scarico_magazzino04');
*/
Route::any('magazzino/inventario', 'HomeController@inventario_magazzino');
Route::any('magazzino/cercadoc/{ordine}', 'HomeController@cercadoc');
Route::any('calcola_totali_ordine', 'HomeController@calcola_totali_ordine');

Route::any('ajax/cerca_articolo/{q}', 'AjaxController@cerca_articolo');
Route::any('ajax/cerca_articolo_trasporto/{q}', 'AjaxController@cerca_articolo_trasporto');
Route::any('ajax/cerca_articolo_new/{q}/{dest}/{forn}', 'AjaxController@cerca_articolo_new');
Route::any('ajax/cerca_fornitore/{q}', 'AjaxController@cerca_fornitore');
Route::any('ajax/cerca_fornitore_new/{q}/{dest}', 'AjaxController@cerca_fornitore_new');
Route::any('ajax/cerca_cliente/{q}', 'AjaxController@cerca_cliente');
Route::any('ajax/cerca_cliente_new/{q}/{dest}', 'AjaxController@cerca_cliente_new');
Route::any('ajax/cerca_fornitore', 'AjaxController@cerca_fornitore');
Route::any('ajax/cerca_cliente', 'AjaxController@cerca_cliente');

Route::any('ajax/cerca_articolo_inventario/{barcode}', 'AjaxController@cerca_articolo_inventario');
Route::any('ajax/cerca_articolo_inventario_codice/{codice}/{arlotto}', 'AjaxController@cerca_articolo_inventario_codice');
Route::any('ajax/rettifica_articolo/{codice}/{quantita}/{lotto}/{magazzino}', 'AjaxController@rettifica_articolo');
Route::any('ajax/cerca_articolo_smart_inventario/{q}/{tipo}', 'AjaxController@cerca_articolo_smart_inventario');


Route::any('ajax/inserisci_lotto/{lotto}/{cd_ar}/{fornitore}/{descrizione}/{fornitore_pallet}/{pallet}', 'AjaxController@inserisci_lotto');
Route::any('ajax/visualizza_lotti/{cd_ar}', 'AjaxController@visualizza_lotti');
//Route::any('ajax/storialotto/{cd_ar}/{lotto}', 'AjaxController@storialotto');
Route::any('ajax/segnalazione/{dotes}/{dorig}/{testo}', 'AjaxController@segnalazione');
Route::any('ajax/invia_mail/{dotes}/{dorig}/{testo}', 'AjaxController@invia_mail');
Route::any('ajax/segnalazione_salva/{dotes}/{dorig}/{testo}', 'AjaxController@segnalazione_salva');
Route::any('ajax/cerca_articolo_barcode/{cd_cf}/{barcode}', 'AjaxController@cerca_articolo_barcode');
//Route::any('ajax/evadi_documento/{dotes}/{cd_do}/{magazzino_A}', 'AjaxController@evadi_documento');
//Route::any('ajax/evadi_documento1/{dotes}/{cd_do}/{magazzino_A}', 'AjaxController@evadi_documento1');
Route::any('ajax/salva_documento1/{dotes}/{cd_do}/{magazzino_A}', 'AjaxController@salva_documento1');
Route::any('ajax/evadi_articolo/{dorig}/{qtaevasa}/{magazzino}/{ubicazione}/{lotto}/{cd_cf}/{documento}/{cd_ar}/{magazzino_A}', 'AjaxController@evadi_articolo');
Route::any('ajax/evadi_articolo2/{dorig}/{qtaevasa}/{magazzino}/{ubicazione}/{lotto}/{cd_cf}/{documento}/{cd_ar}/{magazzino_A}', 'AjaxController@evadi_articolo2');
Route::any('ajax/cerca_articolo_codice/{cd_cf}/{codice}/{Cd_ARLotto}/{qta}', 'AjaxController@cerca_articolo_codice');
Route::any('ajax/aggiungi_articolo_ordine/{id_ordine}/{codice}/{quantita}/{magazzino_A}/{ubicazione_A}/{lotto}/{magazzino_P}/{ubicazione_P}', 'AjaxController@aggiungi_articolo_ordine');
Route::any('ajax/trasporto_articolo/{documento}/{codice}/{quantita}/{magazzino}/{ubicazione_P}/{magazzino_A}/{ubicazione_A}/{fornitore}/{lotto}/{dotes}', 'AjaxController@trasporto_articolo');
Route::any('ajax/modifica_articolo_ordine/{id_ordine}/{codice}/{quantita}/{magazzino_A}/{ubicazione_A}/{lotto}/{magazzino_P}/{ubicazione_P}', 'AjaxController@modifica_articolo_ordine');
Route::any('ajax/scarica_articolo_ordine/{id_ordine}/{codice}/{quantita}/{magazzino}/{ubicazione}/{lotto}', 'AjaxController@scarica_articolo_ordine');
Route::any('ajax/crea_documento/{cd_cf}/{cd_do}/{numero}/{data}', 'AjaxController@crea_documento');
//Route::any('ajax/crea_documento_trasporto/{cd_do}/{numero}/{data}', 'AjaxController@crea_documento_trasporto');
Route::any('ajax/crea_documento_rif/{cd_cf}/{cd_do}/{numero}/{data}/{numero_rif}/{data_rif}', 'AjaxController@crea_documento_rif');
Route::any('ajax/cerca_articolo_smart/{q}/{cd_cf}', 'AjaxController@cerca_articolo_smart');
Route::any('ajax/cerca_documento/{q}', 'AjaxController@cerca_documento');
Route::any('ajax/cerca_documento2/{q}', 'AjaxController@cerca_documento2');
Route::any('ajax/controllo_articolo_smart/{q}/{id_dotes}/{dorig}', 'AjaxController@controllo_articolo_smart');
Route::any('ajax/controllo_articolo_smart2/{id_dorig}/{id_dotes}', 'AjaxController@controllo_articolo_smart2');
Route::any('ajax/esplodi/{id_dorig}', 'AjaxController@esplodi');
