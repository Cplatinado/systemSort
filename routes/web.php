<?php



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


//ROTAS DE LOGIN

Route::group(['namespace'=>'admin', 'as'=> 'admin.'],function (){
    Route::get('login','AuthController@home')->name('login');
    Route::post('logout','AuthController@logout')->name('logout');
    Route::post('login','AuthController@Autenticate')->name('login.do');
    Route::get('login/cadastro','AuthController@register')->name('register');
    Route::post('login/cadastro','AuthController@registerDo')->name('register.do');

});


// ROTAS PROTEGIDAS
Route::group(['namespace'=> 'Admin', 'as'=> 'admin.', 'middleware' => ['auth']],function (){

    Route::get('dashbord','DashbordController@index')->name('dashbord');

    //sorteios
    Route::get('sorteios/ativos','SortController@ativos')->name('sorteio.ativos');
    Route::post('sortear/{id}','SortController@sortear')->name('sortear');
    Route::post('lancar/sorteio/{id}','SortController@lancar')->name('lancar.sort');
    Route::post('finalizar/{id}','SortController@finalizar')->name('finalizar.sort');
    Route::get('sorteios/inativos','SortController@inativos')->name('sorteio.inativos');
    Route::get('sorteios/sortear','SortController@inativos')->name('sorteio.sortear');
    Route::delete('sorteios/image/del/','SortController@imageDestroy')->name('image.destroy');
    Route::post('sorteios/image/cover/','SortController@imageCover')->name('image.cover');


    Route::resource('sorteios','SortController');


    //promoções
    Route::delete('promocoes/image/del/','PromotionController@imageDestroy')->name('promotion.image.destroy');
    Route::post('promocoes/image/cover/','PromotionController@imageCover')->name('promotion.image.cover');
    Route::get('promocoes/ativas','PromotionController@ativos')->name('promocoes.ativos');
    Route::get('promocoes/inativas','PromotionController@inativos')->name('promocoes.inativos');
    Route::post('lancar/promotion/{id}','SortController@lancar')->name('lancar.promotion');

    Route::post('validar-cupom/{id}','PromotionController@ValidarCupom')->name('validarCupom');
    Route::post('finalizar/promo/{id}','PromotionController@finalizarPromo')->name('finalizar.promo');
    Route::resource('promocoes','PromotionController');



});


Route::group(['namespace'=>'web', 'as'=> 'web.'],function (){

    //rotas web - index
    Route::get('/','webController@index')->name('index');
    Route::get('/sorteio/{sorteio}','webController@show')->name('sort');
    Route::get('/lista-sorteios','webController@sorteios')->name('sorteios');
    Route::post('/participar/sorteios','webController@sorteiosParticipar')->name('sorteios.participar');
    Route::post('/participar/promocoes','webController@promocoesParticipar')->name('promocoes.participar');

    Route::get('/comfirmar-email/{hash}','webController@Promovalidator')->name('Promovalidator');
    Route::get('/comfirmar-email-promo/{hash}','webController@Sortvalidator')->name('Sortvalidator');

    Route::get('/lista-promocoes','webController@promocoes')->name('promotions');
    Route::post('/captura','webController@captura')->name('captura');
    Route::get('/promocao/{promocao}','webController@promotion')->name('promotion');





});



//
