<?php
/**
 * Created by PhpStorm.
 * User: umid
 * Date: 7/22/21
 * Time: 7:44 PM
 */

namespace App\Structures;


use Illuminate\Container\Container;
use Illuminate\Routing\RouteBinding;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RpcBinder
{
    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * The registered route value binders.
     *
     * @var array
     */
    protected $binders = [];

    /**
     * Application constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register a model binder for a wildcard.
     *
     * @param string $key
     * @param string $class
     * @param \Closure|null $callback
     *
     * @return void
     */
    public function model(string $key, string $class, \Closure $callback = null)
    {
        $this->bind($key, RouteBinding::forModel($this->container, $class, $callback));
    }

    /**
     * Add a new route parameter binder.
     *
     * @param string $key
     * @param \Closure|string $binder
     *
     * @return void
     */
    public function bind(string $key, $binder)
    {
        $this->binders[$key] = RouteBinding::forCallback(
            $this->container, $binder
        );
    }


    public function bindResolve(array $params): array
    {
        $possibleBindings = Arr::dot($params);

        return collect($possibleBindings)
            ->map(function ($value, string $key) {
                return with($value, $this->binders[$key] ?? null);
            })
            ->mapWithKeys(function ($value, string $key) {
                $nameForArgument = (string)Str::of($key)->replace('.', '_');

                return [$nameForArgument => $value];
            })
            ->toArray();
    }

}
