<?php

namespace Sajjadgol\PasswordChangedNotification\Traits;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Sajjadgol\PasswordChangedNotification\Mail\PasswordChangeNotificationMail;
use Sajjadgol\PasswordChangedNotification\Observers\PasswordChangeObserver;

trait PasswordChangedNotificationTrait
{
    public static function booted(): void
    {
        static::observe(PasswordChangeObserver::class);
    }

    public function passwordColumnName(): string
    {
        return 'password';
    }

    public function emailColumnName(): string
    {
        return 'email';
    }

    public function passwordChangedNotificationMail(): Mailable
    {
        return new PasswordChangeNotificationMail();
    }

    public function isPasswordChanged(): bool
    {
        return $this->wasChanged($this->passwordColumnName());
    }

    public function isPasswordChangedNotificationMailBeQueued(): bool
    {
        return false;
    }

    public function sendPasswordChangeNotification(): void
    {
        if (! $this->isPasswordChanged()) {
            return;
        }

        $mail = Mail::to($this->getRawOriginal($this->emailColumnName()));
        if ($this->isPasswordChangedNotificationMailBeQueued()) {
            $mail->queue($this->passwordChangedNotificationMail());

            return;
        }

        $mail->send($this->passwordChangedNotificationMail());
    }
}
