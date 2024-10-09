<?php

declare(strict_types=1);

namespace EchoLabs\Prism\Facades;

use Closure;
use EchoLabs\Prism\Generators\TextGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static self register(string $name, Closure():TextGenerator|callable():TextGenerator $prism)
 * @method static Collection<int, array{name: string, prism: Closure():TextGenerator|callable():TextGenerator}> prisms()
 */
class PrismServer extends Facade
{
    #[\Override]
    protected static function getFacadeAccessor(): string
    {
        return 'prism-server';
    }
}