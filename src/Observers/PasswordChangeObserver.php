<?php

namespace Sajjadgol\PasswordChangedNotification\Observers;

use Sajjadgol\PasswordChangedNotification\Contracts\PasswordChangedNotificationContract;

/**
 * php artisan make:observer PasswordChangeObserver
 */
class PasswordChangeObserver
{
    public function updated(PasswordChangedNotificationContract $model): void
    {
        $model->sendPasswordChangeNotification();
    }
}
