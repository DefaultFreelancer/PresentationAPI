<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//==============Auth routes================
$router->post('/auth/login', 'AuthController@auth');
//$router->get('/auth', 'AuthController@getAuth');
$router->group(['middleware' => 'jwt.auth'], function () use ($router) {

    //==========User routes============
    $router->get('/user', 'UserController@getAllUsers');
    $router->get('/user/{id:[0-9]+}', 'UserController@getOneUser');
    $router->post('/user', 'UserController@createUser');
    $router->put('/user/{id:[0-9]+}', 'UserController@updateUser');
    $router->delete('/user/{id:[0-9]+}', 'UserController@deleteUser');
    $router->get('/user/autocomplete', 'UserController@autocomplete');

    //==========Roles routes============
    $router->get('/role', 'RoleController@getAllRoles');
    $router->get('/role/{id:[0-9]+}', 'RoleController@getOneRole');
    $router->post('/role', 'RoleController@createRole');
    $router->put('/role/{id:[0-9]+}', 'RoleController@updateRole');
    $router->delete('/role/{id:[0-9]+}', 'RoleController@deleteRole');
    $router->get('/role/autocomplete', 'RoleController@autocomplete');

    //==========Root routes============
    $router->get('/root', 'RootController@getAllRoots');
    $router->get('/root/{id:[0-9]+}', 'RootController@getOneRoot');
    $router->post('/root', 'RootController@createRoot');
    $router->put('/root/{id:[0-9]+}', 'RootController@updateRoot');
    $router->delete('/root/{id:[0-9]+}', 'RootController@deleteRoot');
    $router->delete('/root/bulk', 'RootController@bulkDeleteRoot');
    $router->get('/root/autocomplete', 'RootController@autocomplete');
    $router->get('/root/options', 'RootController@options');

    //==========RootClass routes============
    $router->get('/root/class', 'RootClassController@getAllRootClasses');
    $router->get('/root/class/{id:[0-9]+}', 'RootClassController@getOneRootClass');

    //==========RootPattern routes============
    $router->get('/root/pattern', 'RootPatternController@getAllPatternes');
    $router->get('/root/pattern/{id:[0-9]+}', 'RootPatternController@getOnePattern');

    //==========RootTable routes============
    $router->get('/root/table/options', 'RootTableController@getOptions');
    $router->get('/root/table/filters', 'RootTableController@getFilters');
    $router->post('/root/table/search', 'RootTableController@search');

    //==========Job routes============
    $router->get('/job', 'JobController@getJobs');
    $router->get('/job/{id:[0-9]+}', 'JobController@getOneJob');
    $router->post('/job', 'JobController@createJob');
    $router->put('/job/{id:[0-9]+}', 'JobController@updateJob');
    $router->delete('/job/{id:[0-9]+}', 'JobController@deleteJob');
    $router->get('/job/autocomplete', 'JobController@autocomplete');

    //==========Country routes============
    $router->get('/country', 'CountryController@getAllCountries');

    //==========Institution routes============
    $router->get('/institution', 'InstitutionController@getAllInstitutions');

    //==========Word routes=================
    $router->get('/word', 'WordController@getAllWords');
    $router->get('/word/{id:[0-9]+}', 'WordController@getOneWord');
    $router->post('/word', 'WordController@createWord');
    $router->put('/word/{id:[0-9]+}', 'WordController@updateWord');
    $router->delete('/word/{id:[0-9]+}', 'WordController@deleteWord');
    $router->get('/word/type', 'WordController@getAllWordsTypes');
    $router->delete('/word/bulk/remove', 'WordController@bulkDeleteWords');
    $router->get('/word/autocomplete', 'WordController@autocomplete');

    $router->get('/word/adjectiveTypePattern', 'WordController@getAdjectiveTypePattern');
    $router->get('/word/nounAttribution', 'WordController@getNounAttribution');
    $router->get('/word/nounClassPlural', 'WordController@getNounClassPlural');
    $router->get('/word/nounMinimize', 'WordController@getNounMinimize');
    $router->get('/word/nounSex', 'WordController@getNounSex');
    $router->get('/word/nounSexHow', 'WordController@getNounSexHow');
    $router->get('/word/nounType', 'WordController@getNounType');
    $router->get('/word/verbPhonologicalRule', 'WordController@getVerbPhonologicalRule');
    $router->get('/word/verbSyntaxicalRule', 'WordController@getVerbSyntaxicalRule');
    $router->get('/word/pattern', 'WordController@getPattern');
    $router->get('/word/options', 'WordController@getOptions');

    //===========WordTable routes============
    $router->get('/word/table/options', 'WordTableController@getOptions');
    $router->get('/word/table/filters', 'WordTableController@getFilters');
    $router->post('/word/table/search', 'WordTableController@search');

    $router->get('/auth', 'AuthController@getAuth');
    $router->get('/auth/user', 'AuthController@getUser');
    $router->post('/auth/extend', 'AuthController@extend');
    $router->get('/auth/logout', 'AuthController@logout');
    $router->post('/auth/logout', 'AuthController@logout');


    //==========Notification routes============
    $router->get('/notification', 'NotificationController@getNotifications');
    $router->patch('/notification/{id}', 'NotificationController@seen');
    $router->delete('/notification/{id}', 'NotificationController@delete');
    $router->get('/notification/status', 'NotificationController@notificationStatus');

    //==============Idiom routes====================
    $router->get('/idiom', 'IdiomController@getAllIdioms');
    $router->get('/idiom/{id:[0-9]+}', 'IdiomController@getOneIdiom');
    $router->post('/idiom', 'IdiomController@createIdiom');
    $router->put('/idiom/{id:[0-9]+}', 'IdiomController@updateIdiom');
    $router->delete('/idiom/{id:[0-9]+}', 'IdiomController@deleteIdiom');
    $router->get('/idiom/autocomplete', 'IdiomController@autocomplete');

    //============WordActivity routes=================
    $router->get('/word/{wordId:[0-9]+}/activity', 'WordActivityController@getAllWordActivities');
    $router->post('/word/{wordId:[0-9]+}/activity', 'WordActivityController@createWordActivity');
    $router->put('/word/{wordId:[0-9]+}/activity/{wordActivityId:[0-9]+}', 'WordActivityController@updateWordActivity');
    $router->delete('/word/{wordId:[0-9]+}/activity/{wordActivityId:[0-9]+}', 'WordActivityController@deleteWordActivity');

    //=============== Citation routes =================
    $router->get('/word/{wordId:[0-9]+}/citation', 'CitationController@citationList');
    $router->get('/word/{wordId:[0-9]+}/citation/{id:[0-9]+}', 'CitationController@get');
    $router->get('/word/{wordId:[0-9]+}/citation/options', 'CitationController@getOptionsForWord');
    $router->put('/word/{wordId:[0-9]+}/citation/{id:[0-9]+}', 'CitationController@citationUpdate');
    $router->post('/word/{wordId:[0-9]+}/citation', 'CitationController@add');
    $router->delete('/word/{wordId:[0-9]+}/citation/{id:[0-9]+}', 'CitationController@citationDelete');

    //================Nature routes===================
    $router->get('/nature', 'NounNatureController@getAll');
    $router->get('/nature/{id:[0-9]+}', 'NounNatureController@get');
    $router->post('/nature', 'NounNatureController@create');
    $router->put('/nature/{id:[0-9]+}', 'NounNatureController@update');
    $router->delete('/nature/{id:[0-9]+}', 'NounNatureController@delete');

    //================Domain routes===================
    $router->get('/domain', 'ScientificDomainController@getAll');
    $router->get('/domain/{id:[0-9]+}', 'ScientificDomainController@get');
    $router->post('/domain', 'ScientificDomainController@create');
    $router->put('/domain/{id:[0-9]+}', 'ScientificDomainController@update');
    $router->delete('/domain/{id:[0-9]+}', 'ScientificDomainController@delete');

    //================Source routes===================
    $router->get('/source', 'SourceController@getAll');
    $router->get('/source/{id:[0-9]+}', 'SourceController@get');
    $router->post('/source', 'SourceController@create');
    $router->put('/source/{id:[0-9]+}', 'SourceController@update');
    $router->delete('/source/{id:[0-9]+}', 'SourceController@delete');

    //==============WordType========================
    $router->get('/wordtype', 'WordTypeController@getWordTypes');
    //============Files routes=================
    $router->post('/files', 'FilesController@uploadFile');
    $router->get('/files', 'FilesController@getAllFiles');
    $router->get('/files/{name}', 'FilesController@downloadFile');
    $router->patch('/files/{name}', 'FilesController@updateFile');
    $router->delete('files/{name}', 'FilesController@deleteFile');

    //============CitationActivity routes=================
    $router->get('/word/{wordId:[0-9]+}/citation/{citationId:[0-9]+}/activity', 'CitationActivityController@getAllCitationActivities');
    $router->post('/word/{wordId:[0-9]+}/citation/{citationId:[0-9]+}/activity', 'CitationActivityController@createCitationActivity');
    $router->put('/word/{wordId:[0-9]+}/citation/{citationId:[0-9]+}/activity/{citationActivityId:[0-9]+}', 'CitationActivityController@updateCitationActivity');
    $router->delete('/word/{wordId:[0-9]+}/citation/{citationId:[0-9]+}/activity/{citationActivityId:[0-9]+}', 'CitationActivityController@deleteCitationActivity');

});