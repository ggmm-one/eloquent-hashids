<?php

namespace Ggmm\Model;

use Hashids;

trait HashidRoutable
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field == 'hashid') {
            $value = $this->getKey();
            $field = $this->getKeyName();
        }
        return parent::resolveRouteBinding($value, $field);
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param  string  $childType
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        if ($field == 'hashid') {
            $value = $this->getKey();
            $field = $this->getKeyName();
        }
        return parent::resolveChildRouteBinding($childType, $value, $field);
    }
}
