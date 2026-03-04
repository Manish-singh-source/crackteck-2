<?php

namespace App\Helpers;

class AuthorizeUser
{
    /**
     * Condition 1: Check if all products of a service have diagnosis_completed status
     * If yes, update all product statuses to completed
     *
     * @param  int  $id
     * @param  string  $guard
     * @return bool
     */
    public static function authorizeUser($id, $guard)
    {
        if ($id !== auth($guard)->id()) {
            return false;
        }

        return true;
    }
}
