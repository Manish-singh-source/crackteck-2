<?php

namespace App\Helpers;

class ActivityLogger
{
    /**
     * Log an activity with IP address.
     *
     * @param  string  $logName
     * @param  string  $description
     * @param  mixed  $subject
     * @param  array  $properties
     * @return void
     */
    public static function log($logName, $description, $subject = null, $properties = [])
    {
        $properties['ip'] = request()->ip();
        $properties['user_agent'] = request()->userAgent();

        activity($logName)
            ->performedOn($subject)
            ->withProperties($properties)
            ->log($description);
    }

    /**
     * Log authentication activity.
     *
     * @param  string  $event
     * @param  mixed  $user
     * @return void
     */
    public static function logAuth($event, $user = null)
    {
        $user = $user ?? auth()->user();

        if ($user) {
            self::log(
                'authentication',
                "User {$event}",
                $user,
                [
                    'event' => $event,
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                ]
            );
        }
    }
}
