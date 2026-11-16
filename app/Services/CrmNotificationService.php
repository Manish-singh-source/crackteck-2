<?php

namespace App\Services;

use App\Jobs\SendFcmNotification;
use App\Models\Staff;
use App\Notifications\CrmActivityNotification;
use Illuminate\Support\Str;

class CrmNotificationService
{
    /**
     * Publishes one CRM action to the in-app database inbox and every registered
     * staff app/browser token. The event is intentionally generic so every CRM
     * sidebar module gets consistent notifications without duplicated controller code.
     */
    public function publish(string $routeName, ?Staff $actor = null, ?string $url = null): void
    {
        $label = $this->labelFor($routeName);
        $actorName = trim(($actor?->first_name ?? '').' '.($actor?->last_name ?? '')) ?: 'A CRM user';
        $recipients = Staff::query()
            ->where(function ($query) {
                $query->whereNull('status')->orWhereNotIn('status', ['inactive', 'Inactive', 'deleted']);
            })
            ->get();

        if ($recipients->isEmpty()) {
            return;
        }

        $payload = [
            'title' => $label,
            'message' => $actorName.' updated '.$label.'.',
            'category' => 'crm',
            'route_name' => $routeName,
            'url' => $url,
            'actor_id' => $actor?->getKey(),
            'created_at' => now()->toIso8601String(),
        ];

        $recipients->each(fn (Staff $staff) => $staff->notify(new CrmActivityNotification($payload)));

        SendFcmNotification::dispatch(
            $recipients->pluck('id')->all(),
            $payload['title'],
            $payload['message'],
            ['category' => 'crm', 'url' => $url ?? '', 'route_name' => $routeName]
        );
    }

    private function labelFor(string $routeName): string
    {
        $module = Str::of($routeName)
            ->replaceMatches('/\.(store|update|delete|destroy|status|approve|assign|mark-received)$/', '')
            ->replace(['-', '_', '.'], ' ')
            ->title();

        return $module->isNotEmpty() ? (string) $module : 'CRM record';
    }
}
