<?php

namespace App\Iterators;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Iterator;

class PostSearchIterator implements Iterator, Jsonable
{
    protected Collection $posts;
    protected int $position = 0;

    public function __construct(Collection $posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->posts[$this->position];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @return void
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->posts[$this->position]);
    }

    /**
     * @param $options
     * @return string
     */
    public function toJson($options = 0): string
    {
        return $this->posts->toJson($options);
    }
}
