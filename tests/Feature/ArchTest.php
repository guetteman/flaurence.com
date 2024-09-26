<?php

use App\Providers\Filament\AdminPanelProvider;
use Illuminate\Database\Eloquent\SoftDeletes;

arch()->preset()->laravel()
    ->ignoring(AdminPanelProvider::class);

arch()->preset()->security();

arch()
    ->expect('App\Models')
    ->toUseTrait(SoftDeletes::class);

arch()
    ->expect('App\Actions')
    ->toHaveMethod('execute')
    ->ignoring('App\Actions\Fortify');
