<?php

namespace App\Main\Services;

use App\Main\Repositories\AdminRepository;
use App\Main\Repositories\DashboardRepository;
use App\Main\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class DashboardService
{
    protected DashboardRepository $repository;
    public function __construct(
        DashboardRepository $repository,
    )
    {
        $this->repository = $repository;
    }

    public function getRevenue( $data) {
        $result = $this->repository->getRevenue($data);
        $data = $result['data'];
        return (new \App\Main\Helpers\Response)->responseJsonSuccess($data, );
    }

    public function getHotProducts( $data) {
        $result = $this->repository->getHotProducts($data);
        $data = $result['data'];
        return (new \App\Main\Helpers\Response)->responseJsonSuccess($data, );
    }

}
