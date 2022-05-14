<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use BotMan\BotMan\Drivers\DriverManager;

class IdentifyBotDriver
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $driver = $request->route()->parameter('driver') ?? env('DEFAULT_BOT_DRIVER', 'telegram');

        if ($driver && file_exists(config_path("botman/$driver.php"))) {

            $driver = DriverManager::loadFromName(
                ucfirst($driver),
                config("botman.$driver"),
                $request
            );
            app('botman')->setDriver($driver);
        }

        return $next($request);
    }
}
