<?php

namespace Ggmm\Model;

use Hashids\Hashids;
use Hashids\HashidsInterface;
use Illuminate\Contracts\Support\Arrayable;

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

    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function findByHashid($id, $columns = ['*'])
    {
        return $this->find($this-decodeHashidForQueryBuilder($id), $columns);
    }

    /**
     * Find multiple models by their primary keys.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $ids
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findManyByHashid($ids, $columns = ['*'])
    {
        return $this->findMany($this-decodeHashidForQueryBuilder($ids), $columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|static[]
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFailByHashid($id, $columns = ['*'])
    {
        return $this->findOrFail($this-decodeHashidForQueryBuilder($id), $columns);
    }

    /**
     * Find a model by its primary key or return fresh model instance.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function findOrNewByHashid($id, $columns = ['*'])
    {
        return $this->findOrNew($this-decodeHashidForQueryBuilder($id), $columns);
    }

    private function decodeHashidForQueryBuilder($ids)
    {
        if (is_null($ids)) {
            return null;
        }
        if ($ids instanceof Arrayable) {
            $ids = $ids->toArray();
        }
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $model = new static();

        return array_map(function ($v) use ($model) {
            return $model->decodeHashid($v);
        }, $ids);
    }
}
