<?php

namespace SlackMessage\Models;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Class BaseFilter.
 */
abstract class BaseFilter
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var
     */
    protected $sanitizeSearchPrefix;

    /**
     * @var array
     */
    protected $filterDefaultKeys = ['id', 'name'];

    /**
     * @var null|array|string
     */
    protected $filterKeys = null;

    /**
     * BaseFilter constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->mergeKeys();
        $this->client = $client;
    }

    /**
     * @return Collection
     */
    abstract public function get(): Collection;

    /**
     * @param  array $array
     * @return Collection
     */
    public function filter($array = []): Collection
    {
        $list = $this->get();
        $filtered = collect();
        collect($this->filterDefaultKeys)
            ->each(
                function ($key) use ($list, $filtered, $array) {
                    $search = $list->whereIn($key, $this->sanitizeSearch($array));
                    if ($search->count()) {
                        $filtered->push($search->first());
                    }
                }
            );

        return $filtered;
    }

    /**
     * @param  $array
     * @return Collection
     */
    protected function sanitizeSearch(array $array = [])
    {
        return collect($array)->map(
            function ($search) {
                if ($search[0] === $this->sanitizeSearchPrefix) {
                    return str_replace(['#', '@'], '', $search);
                }

                return false;
            }
        )->filter();
    }

    protected function mergeKeys(): void
    {
        if (is_null($this->filterKeys)) {
            return;
        }
        $this->filterDefaultKeys = array_merge(
            $this->filterDefaultKeys, is_array($this->filterKeys) ? $this->filterKeys : [$this->filterKeys]
        );
    }
}
