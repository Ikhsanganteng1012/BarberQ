<?php

return [
    /*
    | Path relatif ke public/ untuk gambar QRIS (letakkan file di public/images/qris.png)
    | atau URL absolut jika di-hosting eksternal.
    */
    'qris_image' => env('BARBERSHOP_QRIS_IMAGE', 'images/qris-placeholder.png'),

    'bank_name' => env('BARBERSHOP_BANK_NAME', 'Bank BCA'),
    'bank_account_name' => env('BARBERSHOP_BANK_ACCOUNT_NAME', 'BarberShop Modern'),
    'bank_account_number' => env('BARBERSHOP_BANK_ACCOUNT_NUMBER', '1234567890'),
];
