<?php

namespace Crivion\Reladmini;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Crivion\Reladmini\Skeleton\SkeletonClass
 */
class ReladminiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'reladmini';
    }
}
