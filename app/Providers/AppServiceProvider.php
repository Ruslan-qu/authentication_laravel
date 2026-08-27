<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
        return (new MailMessage())
            ->subject('Подтвердите адрес электронной почты')
            ->line('Нажмите кнопку, чтобы подтвердить адрес электронной почты.')
            ->action('Подтвердить адрес', $url)
            ->line('Если вы не создавали учетную запись, никаких дополнительных действий не требуется.');
    });
    }
}
