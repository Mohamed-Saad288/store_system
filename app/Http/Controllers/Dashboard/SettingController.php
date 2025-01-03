<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\SettingRequest;
use App\Http\Requests\Dashboard\Setting\StoreSettingRequest;
use App\Http\Requests\Dashboard\Setting\UpdateSettingRequest;
use App\Services\Setting\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(protected SettingService $setting_service){}
    public function fetch_settings()
    {
        return $this->setting_service->fetch();
    }
    public function show_setting(SettingRequest $request)
    {
        return $this->setting_service->show($request);
    }
    public function store_setting(StoreSettingRequest $request)
    {
        return $this->setting_service->store($request);
    }
    public function update_setting(UpdateSettingRequest $request)
    {
        return $this->setting_service->update($request);
    }
    public function delete_setting(SettingRequest $request)
    {
        return $this->setting_service->delete($request);
    }
}
