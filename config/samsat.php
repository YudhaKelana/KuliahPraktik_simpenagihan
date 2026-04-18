<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Overdue Thresholds
    |--------------------------------------------------------------------------
    */
    'overdue_warning_days' => (int) env('OVERDUE_WARNING_DAYS', 7),
    'overdue_critical_days' => (int) env('OVERDUE_CRITICAL_DAYS', 14),
    'spsopkb_min_followups' => 2,
    'spsopkb_min_age_days' => 14,

    /*
    |--------------------------------------------------------------------------
    | Reminder Email
    |--------------------------------------------------------------------------
    | Konfigurasi untuk sistem pengingat via email.
    | Email menggunakan konfigurasi SMTP dari config/mail.php dan .env
    */
    'reminder' => [
        'channel' => env('REMINDER_CHANNEL', 'email'), // 'email' or 'whatsapp'
        'rate_limit_per_hour' => (int) env('REMINDER_RATE_LIMIT_PER_HOUR', 100),
        'send_window_start' => '08:00',
        'send_window_end'   => '16:00',
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Provider (Deprecated — kept as fallback)
    |--------------------------------------------------------------------------
    | Konfigurasi ini dipertahankan sebagai fallback jika diperlukan.
    | Fitur utama reminder menggunakan email.
    */
    'wa' => [
        'provider' => env('WA_PROVIDER', 'fonnte'),
        'api_url'  => env('WA_API_URL', ''),
        'api_token' => env('WA_API_TOKEN', ''),
        'webhook_secret' => env('WA_WEBHOOK_SECRET', ''),
        'rate_limit_per_hour' => (int) env('WA_RATE_LIMIT_PER_HOUR', 100),
        'send_window_start' => '08:00',
        'send_window_end'   => '16:00',
    ],

    /*
    |--------------------------------------------------------------------------
    | Data Quality
    |--------------------------------------------------------------------------
    */
    'min_phone_digits' => 8,
    'min_address_length' => 10,
];
