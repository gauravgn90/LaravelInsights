<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/pushToInsights', function() {
    $startTime = microtime(true);
    $telemetryClient = new \ApplicationInsights\Telemetry_Client();
    $context = $telemetryClient->getContext();
    
    // Necessary
    $context->setInstrumentationKey('e3cb5a0d-d6df-4cd0-b3b4-84c6fff5f8da');
    
    // Optional
    $context->getSessionContext()->setId(session_id());
    $context->getUserContext()->setId('test_user_1');
    $context->getApplicationContext()->setVer('test_v_1.1');
    $context->getLocationContext()->setIp('127.0.0.1');
    $telemetryClient->getChannel()->setSendGzipped(true);
    // Start tracking
    //for ($i=0; $i < 200; $i++) { 
       // $telemetryClient->trackException(new \Exception("EXCEPTION OCCURRED" . time() . $i), ['test' => 'test_value'], ['duration_inner' => 40.0]);
    //}
    
    //$telemetryClient->trackRequest('myRequest', URL::current(), time(), 3754, 200, true, ['InlineProperty' => 'test_value'], ['duration_inner' => 42.0]);
    $telemetryClient->trackMessage('INFO_MESSAGE', \ApplicationInsights\Channel\Contracts\Message_Severity_Level::INFORMATION, ['InlineProperty' => 'test_value_info']);
    $telemetryClient->trackMessage('WARNING_MESSAGE', \ApplicationInsights\Channel\Contracts\Message_Severity_Level::WARNING, ['InlineProperty' => 'test_value_warning']);
    $telemetryClient->trackMessage('ERROR_MESSAGE', \ApplicationInsights\Channel\Contracts\Message_Severity_Level::ERROR, ['InlineProperty' => 'test_value_error']);
    $telemetryClient->trackMessage('CRITICAL_MESSAGE', \ApplicationInsights\Channel\Contracts\Message_Severity_Level::CRITICAL, ['InlineProperty' => 'test_value_critical']);
    
    //$telemetryClient->trackMessage('this is verbose message just to view what is happening..', \ApplicationInsights\Channel\Contracts\Message_Severity_Level::VERBOSE, ['InlineProperty' => 'test_value_verbose']);

    // $telemetryClient->trackEvent('myFirstEvent', ['MyCustomProperty' => 42, 'MyCustomProperty2' => 'test'], ['duration', 42]);

    $response = $telemetryClient->flush();
   /*  $response->then(function($res){
       // $res->wait();
    }); */
    // dd(get_class_methods($response));

    echo microtime(true)-$startTime;
});