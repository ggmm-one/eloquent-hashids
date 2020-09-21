<?php

namespace Ggmm\Model;

trait HashidRoutable
{
    public function getRouteKeyName()
    {
        return 'hashid';
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->findOrFail($this->decodeHashid($value));
    }
}
