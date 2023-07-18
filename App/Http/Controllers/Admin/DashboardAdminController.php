<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Main\Services\DashboardService;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class DashboardAdminController extends Controller
{
    protected DashboardService $service;

    public function __construct(
        DashboardService $dashboardService
    )
    {
        $this->service = $dashboardService;
    }

    public function getRevenue(Request $request)
    {

        $data = [];

        return $this->service->getRevenue($data);
    }
}
