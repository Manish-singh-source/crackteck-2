<?php

namespace App\Http\Middleware;

use App\Models\Staff;
use App\Services\CrmNotificationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordCrmNotification
{
    public function handle(Request $request, Closure $next): Response
    {
        // Keep the matched route before the controller returns a redirect response.
        // On some form posts the request route is no longer available afterwards.
        $routeName = $request->route()?->getName();
        $shouldRecord = ! $request->is('demo/crm/notifications')
            && ! $request->is('demo/crm/notifications/*')
            && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)
            && filled($routeName);

        $response = $next($request);

        if (! $shouldRecord || $response->getStatusCode() >= 400) {
            return $response;
        }

        $actor = auth('staff_web')->user();
        app(CrmNotificationService::class)->publish(
            $routeName,
            $actor instanceof Staff ? $actor : null,
            url()->previous()
        );

        return $response;
    }
}
