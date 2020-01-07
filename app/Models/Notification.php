<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class Notification extends BaseModel
{
    protected $fillable = ['recipient', 'subject', 'message', 'target', 'user'];
    protected $with = ['user'];

    protected $casts = [
        'created_at' => 'datetime:c',
        'updated_at' => 'datetime:c',
        'seen' => 'datetime:c'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function target(){
        return $this->belongsTo(Target::class, 'target', 'scope');
    }

    /**
     * @param $request
     * @return mixed
     */
    public static function getNotifications($request){
        $notifications =  self::where(['recipient' => Auth::user()->id]);

            if($request->has('limit')) {
                $notifications->limit($request['limit']);
            }else {
                $notifications->limit(20);
            }

            if($request->has('moment')) {
                $date = Carbon::parse($request['moment'])->setTimezone('UTC')->format('Y-m-d H:m:s');
                if($request->has('past') && $request['past'] == "true"){
                    $notifications->whereDate('created_at', '<=',$date);
                }else if($request->has('past') && $request['past'] == "false"){
                    $notifications->whereDate('created_at', '>=',$date);
                }

            }else {
                $notifications->whereDate('created_at', '<=', Carbon::now());
            }

            $notifications->orderBy('created_at','desc');
            $notifications = $notifications->get();
        return $notifications;
    }

    // Create new notification
    public static function new($recipient, $subject, $message, array $target, $user){
        $model = new self();
        $model->recipient = $recipient;
        $model->subject = $subject;
        $model->message = $message;
        $model->target = $target['target'];
        $model->user = $user;
        $model->save();
    }

    // Seen the notification
    public static function seen($id){
        $model = self::find($id);
        if($model){
            $model->seen = Carbon::now();
            $model->save();
            return true;
        }else{
            return false;
        }
    }

    // Delete the notification
    public static function deleteNotification($id){
        $model = self::find($id);
        if($model){
            $model->delete();
            return true;
        }else{
            return false;
        }
    }

    public static function status(){
        $notifications =  self::where(['recipient' => Auth::user()->id])->count();
        $unread =  self::where(['recipient' => Auth::user()->id, 'seen' => null])->count();
        $last = self::where(['recipient' => Auth::user()->id])->orderBy('created_at','desc')->first();

        return [
            'total' => $notifications,
            'unread'=> $unread,
            'last'  => $last->created_at,
        ];
    }


}
