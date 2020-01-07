<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Models\Notification;
use App\Rules\DateTimeISO8601Check;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getNotifications(Request $request){
        $this->validate($request, [
            'limit'        => 'numeric',
            'moment'       =>  new DateTimeISO8601Check,
            'past'         => 'string'
        ]);

        $notifications = Notification::getNotifications($request);

        
        // if(!count($notifications)){
        //     throw new APIException('Notification not found.', APIException::NOT_FOUND);
        // }
        
        return response()->json($notifications);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function seen($id){
        try {
            $model = Notification::find($id);
            if (Auth::user()->id == $model->recipient) {
                $notification = Notification::seen($id);
                if (!$notification) {
                    throw new APIException('Notification not found.', APIException::NOT_FOUND);
                }
            }else{
                throw new APIException('Access forbidden.', APIException::FORBIDDEN);
            }
        } catch (\Exception $e){
            throw $e;
        }
        return response()->json([], 200);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($id){
        try {
            $model = Notification::find($id);
            if (Auth::user()->id == $model->recipient) {
                $notification = Notification::deleteNotification($id);
                if (!$notification) {
                    throw new APIException('Notification not found.', APIException::NOT_FOUND);
                }
            }else{
                throw new APIException('Access forbidden.', APIException::FORBIDDEN);
            }
        } catch (\Exception $e){
            throw $e;
        }
        return response()->json([], 200);
    }


    public function notificationStatus()
    {
        try{
            $status = Notification::status();

            if(!count($status)){
                throw new APIException('Status not found.', APIException::NOT_FOUND);
            }

            return response()->json($status);

        } catch (\Exception $e){
            return response()->json($e);
        }
    }

}
