<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

// WhatsApp Webhook
Route::prefix('webhook/wa')->group(function () {
    Route::post('/status', [WebhookController::class, 'status']);
    Route::post('/inbound', [WebhookController::class, 'inbound']);
});
