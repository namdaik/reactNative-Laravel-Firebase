<?php

namespace App\Traits;

use ExponentPhpSDK\Expo;
use Illuminate\Support\Carbon;

trait NotifiUserWhenUpdate
{
    public static function bootNotifiUserWhenUpdate()
    {
        static::updated(function ($model) {
            $model->sendNotificationToUser($model);
        });
    }

    public function sendNotificationToUser($model)
    {
        $channel_name = 'Order';
        $notification = [
            'title' => "Cập nhật đơn hàng $model->id",
            'sound' => "default",
            'body' => $model->notifiBody($model),
            '_displayInForeground' => true,
            'data' => json_encode($model->toArray())
        ];
        try {            
            $expo = Expo::normalSetup();
            foreach ($model->user->mobile_tokens as $mobile_token) {
                $expo->subscribe($channel_name, $mobile_token);
            }
            $expo->notify([$channel_name], $notification);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function notifiBody($model)
    {
        switch ((int) $model->status) {
            case 1:
                $msg = "Đã xác nhận ";
                break;
            case 2:
                $msg = "Đang vận chuyển ";
                break;
            case 3:
                $msg = "Đang trong bưu cục ";
                break;
            case 4:
                $msg = "Đang giao hàng ";
                break;
            case 5:
                $msg = "Đã giao hàng thành công ";
                break;
            default:
                $msg = "Đã bị hủy ";
                break;
        }
        return $msg . Carbon::parse($model->updated_at)->format('H:i - d/m/Y');
    }
}
