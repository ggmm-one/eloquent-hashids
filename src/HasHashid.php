<?php

namespace Ggmm\Model;

use Hashids\Hashids;
use Hashids\HashidsInterface;
use Illuminate\Database\Eloquent\Builder;

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

    public static function bootHasHashid()
    {
        Builder::macro('findByHashid', function ($id, $columns = ['*']) {
            return $this->find($this->getModel()->decodeHashidForQueryBuilder($id), $columns);
        });
        Builder::macro('findManyByHashid', function ($ids, $columns = ['*']) {
            return $this->findMany($this->getModel()->decodeHashidForQueryBuilder($ids), $columns);
        });
        Builder::macro('findOrFailByHashid', function ($id, $columns = ['*']) {
            return $this->findOrFail($this->getModel()->decodeHashidForQueryBuilder($id), $columns);
        });
        Builder::macro('findOrNewByHashid', function ($id, $columns = ['*']) {
            return $this->findOrNew($this->getModel()->decodeHashidForQueryBuilder($id), $columns);
        });
    }

    public function decodeHashidForQueryBuilder($ids)
    {
        if (is_null($ids)) {
            return null;
        }
        if ($ids instanceof Arrayable) {
            $ids = $ids->toArray();
        }
        if (is_array($ids)) {
            $ids = array_map(function ($v) {
                return $this->decodeHashid($v);
            }, $ids);
        } else {
            $ids = $this->decodeHashid($ids);
        }

        return $ids;
    }
}
