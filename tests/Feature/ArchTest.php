<?php

use App\Providers\Filament\AdminPanelProvider;

arch()->preset()->laravel()
    ->ignoring(AdminPanelProvider::class);

arch()->preset()->security();
