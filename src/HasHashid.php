<?php

use Hashids\Hashids;
use Hashids\HashidsInterface;

trait HasHashid
{
    protected ?HashidsInterface $hashidGenerator = null;

    public function getHashidAttribute()
    {
        $this->initHashidGenerator();
        return $this->hashidGenerator->encode($this->getKey());
    }

    public function decodeHashid($hashid)
    {
        $this->initHashidGenerator();
        return $this->hashidGenerator->decode($hashid)[0];
    }

    private function initHashidGenerator()
    {
        if ($this->hashidGenerator == null) {
            $this->hashidGenerator = new Hashids();
        }
    }
}
