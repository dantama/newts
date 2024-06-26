<?php

namespace App\Models\Traits\Metable\DataType;

/**
 * Handle serialization of integers.
 */
class IntegerHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'integer';
}
