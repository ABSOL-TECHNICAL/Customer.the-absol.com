<?php

namespace App\Providers;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        Field::macro("tooltip", function(string $tooltip) {
            return $this->hintAction
            (
                Action::make('help')
                    ->icon('heroicon-o-question-mark-circle')
                    ->extraAttributes(["class" => "text-gray-500"])
                    ->label("")
                    ->tooltip($tooltip)
            );
        });

        if (config('app.debug')) {
            DB::listen(function ($query) {
                Log::info('Query: ' . $query->sql);
                Log::info('Bindings: ' . json_encode($query->bindings));
                Log::info('Time: ' . $query->time . 'ms');
            });
        }
    }
    }

