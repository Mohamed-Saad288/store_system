<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Governorate\GovernorateRequest;
use App\Http\Requests\Dashboard\Governorate\StoreGovernorateRequest;
use App\Http\Requests\Dashboard\Governorate\UpdateGovernorateRequest;
use App\Http\Requests\General\FetchRequest;
use App\Http\Resources\Dashboard\Governorate\GovernorateResource;
use App\Models\Governorate;
use App\Services\Governorate\GovernorateService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;


class GovernorateController extends Controller
{
    public function __construct(protected GovernorateService $governorate_service){}
    public function fetch_governorates(FetchRequest $request)
    {
        return $this->governorate_service->fetch($request);
    }
    public function show_governorate(GovernorateRequest $request)
    {
        return $this->governorate_service->show($request);
    }
    public function store_governorate(StoreGovernorateRequest $request)
    {
        return $this->governorate_service->store($request);
    }
    public function update_governorate(UpdateGovernorateRequest $request)
    {
        return $this->governorate_service->update($request);
    }
    public function delete_governorate(GovernorateRequest $request)
    {
        return $this->governorate_service->delete($request);
    }
}
