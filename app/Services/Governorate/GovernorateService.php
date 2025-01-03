<?php

namespace App\Services\Governorate;

use App\Http\Requests\Dashboard\Governorate\GovernorateRequest;
use App\Http\Requests\Dashboard\Governorate\StoreGovernorateRequest;
use App\Http\Requests\Dashboard\Governorate\UpdateGovernorateRequest;
use App\Http\Requests\General\FetchRequest;
use App\Http\Resources\Dashboard\Governorate\GovernorateResource;
use App\Models\Governorate;
use App\Traits\ResponseTrait;
use function Laravel\Prompts\search;

class GovernorateService
{
    use ResponseTrait;

    public function fetch(FetchRequest $request)
    {
        $data = $request->validated();
        try {
            $governorates = Governorate::search($data)->paginate(15);
            if ($governorates)
            {
                $message = "تم الوصول لبيانات المحافظات بنجاح";
                return self::dataSuccess(GovernorateResource::collection($governorates),$message);
            }else{
                return self::dataFailed("لم يتم الوصول لبيانات المحافظات");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function show(GovernorateRequest $request)
    {
        $data = $request->validated();
        try {
            $governorate = Governorate::find($data["governorate_id"]);
            if ($governorate)
            {
                $message = "تم الوصول لبيانات المحافظه بنجاح";
                return self::dataSuccess(new GovernorateResource($governorate),$message);

            }else{
                return self::dataFailed("لم يتم الوصول لبيانات المحافظة");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function store(StoreGovernorateRequest $request)
    {
        $data = $request->validated();
        try{
            $governorate =  Governorate::create($data);
            if ($governorate) {
                $message = "تم تخزين المحافظة بنجاح";
                return self::dataSuccess(new GovernorateResource($governorate),$message);
            }else{
                return self::dataFailed("لم يتم تخزين المحافظة");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function update(UpdateGovernorateRequest $request)
    {
        $data = $request->validated();
        try {
            $governorate = Governorate::find($data["governorate_id"]);
             $governorate->update([
                "name" => $data["name"],
            ]);
            if ($governorate)
            {
                $message = "تم تعديل بيانات المحافظه بنجاح";
                return self::dataSuccess(new GovernorateResource($governorate),$message);

            }else{
                return self::dataFailed("لم يتم تعديل بيانات المحافظة");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function delete(GovernorateRequest $request)
    {
        $data = $request->validated();
        try {
            $governorate = Governorate::find($data["governorate_id"]);
            $governorate->delete();
            if ($governorate)
            {
                $message = "تم حذف المحافظه بنجاح";
                return self::dataSuccess(new GovernorateResource($governorate),$message);

            }else{
                return self::dataFailed("لم يتم حذف المحافظة");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

}
