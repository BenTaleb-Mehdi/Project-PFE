<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesAppServices;
use Native\Laravel\Facades\MenuBar;

class NativeAppServiceProvider implements ProvidesAppServices
{
    public function boot(): void
    {
        Window::open()
            ->width(1200)
            ->height(800)
            ->url(config('app.url'))
            ->rememberState();

        MenuBar::create()
            ->icon(public_path('icon.png'));
    }
}