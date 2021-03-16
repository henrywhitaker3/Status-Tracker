<?php

namespace App\Http\Controllers;

use App\Models\ServiceCheck;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceCheckController extends Controller
{
    public function show(ServiceCheck $serviceCheck)
    {
        return Inertia::render(
            'ServiceChecks/Show',
            [
                'check' => $serviceCheck,
            ]
        );
    }
}
