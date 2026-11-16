<?php

namespace App\Services;

use App\Jobs\SendFcmNotification;
use App\Models\Customer;
use App\Models\Staff;
use App\Notifications\CrmActivityNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CrmNotificationService
{
    /**
     * Publishes one CRM action to the in-app database inbox and every registered
     * staff app/browser token. The event is intentionally generic so every CRM
     * sidebar module gets consistent notifications without duplicated controller code.
     */
    public function publish(string $routeName, ?Model $actor = null, ?string $url = null): void
    {
        $label = $this->labelFor($routeName);
        $actorName = trim(($actor?->first_name ?? '').' '.($actor?->last_name ?? ''))
            ?: ($actor?->name ?? 'A CRM user');
        $staffRecipients = Staff::query()
            ->where(function ($query) {
                $query->whereNull('status')->orWhereNotIn('status', ['inactive', 'Inactive', 'deleted']);
            })
            ->get();

        $customerRecipients = $actor instanceof Customer ? collect([$actor]) : collect();

        if ($staffRecipients->isEmpty() && $customerRecipients->isEmpty()) {
            return;
        }

        $payload = [
            'title' => $label,
            'message' => $actorName.' '.$this->verbFor($routeName).' '.$label.'.',
            'category' => 'crm',
            'route_name' => $routeName,
            'url' => $url,
            'actor_id' => $actor?->getKey(),
            'created_at' => now()->toIso8601String(),
        ];

        $staffRecipients->each(fn (Staff $staff) => $staff->notify(new CrmActivityNotification($payload)));
        $customerRecipients->each(fn (Customer $customer) => $customer->notify(new CrmActivityNotification($payload)));

        SendFcmNotification::dispatch(
            $staffRecipients->pluck('id')->all(),
            $payload['title'],
            $payload['message'],
            ['category' => 'crm', 'url' => $url ?? '', 'route_name' => $routeName],
            $customerRecipients->pluck('id')->all(),
        );
    }

    private function labelFor(string $routeName): string
    {
        $module = Str::of($routeName)
            ->replaceMatches('/\.(store|update|delete|destroy|status|approve|assign|mark-received)$/', '')
            ->replace(['-', '_', '.'], ' ')
            ->replace('api ', '')
            ->trim();

        return $module->isNotEmpty() ? Str::headline((string) $module) : 'CRM record';
    }

    private function verbFor(string $routeName): string
    {
        $action = Str::afterLast($routeName, '.');

        if (in_array($action, ['delete', 'destroy', 'remove'], true)) {
            return 'deleted';
        }

        if (in_array($action, ['store', 'create', 'submit', 'add', 'buy_product', 'request_product'], true)) {
            return 'created';
        }

        return 'updated';
    }
}
