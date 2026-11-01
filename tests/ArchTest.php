<?php

arch()->preset()->php();

arch()->preset()->security();

arch('the core depends on saloon only')
    ->expect('Autoznetwork\AutozNetwork')
    ->not->toUse('Illuminate')
    ->ignoring('Autoznetwork\AutozNetwork\Laravel');

arch('requests are saloon requests')
    ->expect('Autoznetwork\AutozNetwork\Requests')
    ->toExtend('Saloon\Http\Request')
    ->toHaveSuffix('Request');

arch('resources extend the base resource')
    ->expect('Autoznetwork\AutozNetwork\Resources')
    ->toExtend('Autoznetwork\AutozNetwork\Resources\BaseResource')
    ->toHaveSuffix('Resource')
    ->ignoring('Autoznetwork\AutozNetwork\Resources\BaseResource');
