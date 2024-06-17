<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Models\Organization;

Route::view('/', 'web::index')->name('index');

Route::redirect('/pesan', 'https://forms.gle/8oUGq1SBVH6LXfGq8');

Route::get('/test-script', function () {
    // Example value, replace with your actual data
    $value = [
        'member' => [
            'pimda' => '001'
        ]
    ];

    // Find the organization by meta value
    $organization = Organization::whereMeta('org_code', '=', $value['member']['pimda'])->first();

    // Check if the organization is found and return the id
    if ($organization) {
        return response()->json(['organization_id' => $organization->id]);
    } else {
        return response()->json(['error' => 'Organization not found'], 404);
    }
});
