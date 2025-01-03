<?php

namespace App\Services\Setting;

use App\Http\Requests\Dashboard\Setting\SettingRequest;
use App\Http\Requests\Dashboard\Setting\StoreSettingRequest;
use App\Http\Requests\Dashboard\Setting\UpdateSettingRequest;
use App\Http\Resources\Dashboard\Setting\SettingResource;
use App\Models\Setting;
use App\Traits\ResponseTrait;

class SettingService
{
    use ResponseTrait;

    public function fetch()
    {
        try {
            $settings = Setting::paginate(15);
            if ($settings)
            {
                $message = "تم الوصول للبيانات بنجاح";
                return self::dataSuccess(SettingResource::collection($settings),$message);
            }else{
                return self::dataFailed("لم يتم الوصول للبيانات");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function show(SettingRequest $request)
    {
        $data = $request->validated();
        try {
            $setting = Setting::find($data["setting_id"]);
            if ($setting)
            {
                $message = "تم الوصول للبيانات بنجاح";
                return self::dataSuccess(new SettingResource($setting),$message);

            }else{
                return self::dataFailed("لم يتم الوصول لبيانات ");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function store(StoreSettingRequest $request)
    {
        $data = $request->validated();
        try{
            $setting =  Setting::create($data);
            if ($setting) {
                $message = "تم تخزين بنجاح";
                return self::dataSuccess(new SettingResource($setting),$message);
            }else{
                return self::dataFailed("لم يتم تخزين");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function update(UpdateSettingRequest $request)
    {
        $data = $request->validated();
        try {
            $setting = Setting::find($data["setting_id"]);
            $setting->update([
                "delivery" => $data["delivery"],
                "setting_id" => $data["setting_id"],
            ]);
            if ($setting)
            {
                $message = "تم تعديل بيانات بنجاح";
                return self::dataSuccess(new SettingResource($setting),$message);

            }else{
                return self::dataFailed("لم يتم تعديل بيانات");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function delete(SettingRequest $request)
    {
        $data = $request->validated();
        try {
            $setting = Setting::find($data["setting_id"]);
            $setting->delete();
            if ($setting)
            {
                $message = "تم حذف بنجاح";
                return self::dataSuccess(new SettingResource($setting),$message);

            }else{
                return self::dataFailed("لم يتم حذف");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }



}
