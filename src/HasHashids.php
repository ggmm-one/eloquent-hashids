<?php

namespace Ggmm\Model;

use Hashids;

trait HasHashids
{
    protected HashidsInterface $hashidGenerator;

    public function getHashidAttribute()
    {
        $this->initHashidGenerator();
        return $this->hashidGenerator->encode($this->getKey());
    }

    public function decodeHashid($hashid)
    {
        $this->initHashidGenerator();
        return $this->hashidGenerator->decode($hashid);
    }

    private function initHashidGenerator()
    {
        if ($this->hashidGenerator == null) {
            $this->hashidGenerator = new Hashids();
        }
    }
}
