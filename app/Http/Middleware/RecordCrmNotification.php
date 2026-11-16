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
        $response = $next($request);

        if ($request->is('demo/crm/notifications/*')
            || ! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)
            || $response->getStatusCode() >= 400
            || ! $request->route()?->getName()) {
            return $response;
        }

        $actor = auth('staff_web')->user();
        app(CrmNotificationService::class)->publish(
            $request->route()->getName(),
            $actor instanceof Staff ? $actor : null,
            url()->previous()
        );

        return $response;
    }
}
