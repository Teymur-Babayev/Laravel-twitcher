<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ScheduleController extends Controller
{
    public function getScheduleInfo(User $user)
    {
        return user_meta('schedule_info', true, $user->id);
    }

    public function getSchedule(User $user)
    {
        if ($meta = user_meta('schedule', true, $user->id)) {
            return $meta;
        }

        $defaultSchedule = [
            "Monday" => [
                "day_name" => __("Monday"),
                "from_hour" => '',
                "from_minute" => '',
                "from_type" => "AM",
                "to_hour" => '',
                "to_minute" => '',
                "to_type" => "PM",
            ],
            "Tuesday" => [
                "day_name" => __("Tuesday"),
                "from_hour" => '',
                "from_minute" => '',
                "from_type" => "AM",
                "to_hour" => '',
                "to_minute" => '',
                "to_type" => "PM",
            ],
            "Wednesday" => [
                "day_name" => __("Wednesday"),
                "from_hour" => '',
                "from_minute" => '',
                "from_type" => "AM",
                "to_hour" => '',
                "to_minute" => '',
                "to_type" => "PM",
            ],
            "Thursday" => [
                "day_name" => __("Thursday"),
                "from_hour" => '',
                "from_minute" => '',
                "from_type" => "AM",
                "to_hour" => '',
                "to_minute" => '',
                "to_type" => "PM",
            ],
            "Friday" => [
                "day_name" => __("Friday"),
                "from_hour" => '',
                "from_minute" => '',
                "from_type" => "AM",
                "to_hour" => '',
                "to_minute" => '',
                "to_type" => "PM",
            ],
            "Saturday" => [
                "day_name" => __("Saturday"),
                "from_hour" => '',
                "from_minute" => '',
                "from_type" => "AM",
                "to_hour" => '',
                "to_minute" => '',
                "to_type" => "PM",
            ],
            "Sunday" => [
                "day_name" => __("Sunday"),
                "from_hour" => '',
                "from_minute" => '',
                "from_type" => "AM",
                "to_hour" => '',
                "to_minute" => '',
                "to_type" => "PM",
            ]
            ];

        return response()->json($defaultSchedule);
    }

    public function saveSchedule(Request $request)
    {
        Gate::authorize('channel-settings');

        $request->validate([
            'schedule' => 'required'
        ]);


        set_user_meta('schedule', json_encode($request->schedule), true, $request->user()->id);
        set_user_meta('schedule_info', $request->scheduleInfo, true, $request->user()->id);

        return back()->with('message', __("Schedule successfully updated."));
    }
}
