<?php

namespace App\Models\Traits\Metable\DataType;

/**
 * Handle serialization of floats.
 */
class FloatHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'double';

    /**
     * {@inheritdoc}
     */
    public function getDataType(): string
    {
        return 'float';
    }
}
