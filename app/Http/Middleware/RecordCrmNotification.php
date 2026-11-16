<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use App\Models\Staff;
use App\Services\CrmNotificationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RecordCrmNotification
{
    public function handle(Request $request, Closure $next): Response
    {
        // Keep the matched route before the controller returns a redirect response.
        // API routes are intentionally named from their controller action because most
        // of the legacy mobile routes do not have an explicit route name.
        $routeName = $this->routeName($request);
        $shouldRecord = ! $this->isExcluded($request)
            && $this->isMutation($request)
            && filled($routeName);

        $response = $next($request);

        if (! $shouldRecord || $response->getStatusCode() >= 400 || $this->hasValidationErrors($request, $response)) {
            return $response;
        }

        $actor = $this->actor($request);
        app(CrmNotificationService::class)->publish(
            $routeName,
            $actor,
            $request->is('api/*') ? null : url()->previous()
        );

        return $response;
    }

    private function routeName(Request $request): ?string
    {
        $route = $request->route();
        $name = $route?->getName();

        if (filled($name)) {
            return $name;
        }

        $action = $route?->getActionName();
        if (! is_string($action) || ! str_contains($action, '@')) {
            return null;
        }

        [$controller, $method] = explode('@', $action, 2);

        return 'api.'.Str::snake(class_basename($controller)).'.'.Str::snake($method);
    }

    private function isExcluded(Request $request): bool
    {
        return $request->is('demo/crm/notifications')
            || $request->is('demo/crm/notifications/*')
            || $request->is('api/v1/notifications')
            || $request->is('api/v1/device-token')
            || $request->is('api/v1/logout')
            || $request->is('api/v1/refresh-token');
    }

    private function isMutation(Request $request): bool
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return true;
        }

        // A few legacy mobile endpoints use GET for workflow transitions. Record
        // only clearly mutating actions, never ordinary list/detail page views.
        $action = (string) $request->route()?->getActionName();

        return (bool) preg_match(
            '/@(accept|approve|reject|cancel|deliver|receive|pick|complete|close|assign|transfer|reschedule|verify|start|logout)/i',
            $action
        );
    }

    private function hasValidationErrors(Request $request, Response $response): bool
    {
        return $response->isRedirection()
            && ! $request->is('api/*')
            && $request->session()->has('errors');
    }

    private function actor(Request $request): Staff|Customer|null
    {
        $staff = auth('staff_web')->user();
        if ($staff instanceof Staff) {
            return $staff;
        }

        if (! $request->is('api/*')) {
            return null;
        }

        return (int) $request->input('role_id') === 4
            ? Customer::find($request->input('user_id'))
            : Staff::find($request->input('user_id'));
    }
}
