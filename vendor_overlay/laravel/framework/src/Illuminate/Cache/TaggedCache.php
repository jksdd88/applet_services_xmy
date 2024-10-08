<?php

namespace Illuminate\Cache;

use Illuminate\Contracts\Cache\Store;

class TaggedCache extends Repository
{
    /**
     * The tag set instance.
     *
     * @var \Illuminate\Cache\TagSet
     */
    protected $tags;

    /**
     * Create a new tagged cache instance.
     *
     * @param  \Illuminate\Contracts\Cache\Store  $store
     * @param  \Illuminate\Cache\TagSet  $tags
     * @return void
     */
    public function __construct(Store $store, TagSet $tags)
    {
        parent::__construct($store);

        $this->tags = $tags;
    }

    /**
     * {@inheritdoc}
     */
    protected function fireCacheEvent($event, $payload)
    {
        $payload[] = $this->tags->getNames();

        parent::fireCacheEvent($event, $payload);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function increment($key, $value = 1)
    {
        $this->store->increment($this->itemKey($key), $value);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function decrement($key, $value = 1)
    {
        $this->store->decrement($this->itemKey($key), $value);
    }

    /**
     * Remove all items from the cache.
     *
     * @return void
     */
    public function flush()
    {
        $this->tags->reset();
    }

    /**
     * {@inheritdoc}
     */
    protected function itemKey($key)
    {
        return $this->taggedItemKey($key);
    }

    /**
     * Get a fully qualified key for a tagged item.
     *
     * @param  string  $key
     * @return string
     */
    public function taggedItemKey($key)
    {
        return sha1($this->tags->getNamespace()).':'.$key;
    }


    /**
     * Increment the value of an item in the cache.
     * 王禹修改 增加返回值
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function incrementGetValue($key, $value = 1)
    {
        return $this->store->increment($this->itemKey($key), $value);
    }

    /**
     * Increment the value of an item in the cache.
     * 王禹修改 增加返回值
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function decrementGetValue($key, $value = 1)
    {
        return $this->store->decrement($this->itemKey($key), $value);
    }
}
