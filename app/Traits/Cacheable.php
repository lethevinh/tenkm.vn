<?php


namespace App\Traits;

use Closure;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

trait Cacheable
{

    protected static $cacheField = 'slug_lb';

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param Closure $builder
     *
     * @return mixed
     */
    public function remember(Closure $builder)
    {
        if (! $this->enableCache()) {
            return $builder();
        }

        return $this->getStore()->remember($this->getCacheKey(), null, $builder);
    }

    /**
     * @param $data
     * @param string $key
     * @return bool
     */
    public function forever($data, $key = '')
    {
        if (!$this->enableCache()) {
            return false;
        }
        $key = !empty($key) ? $key : $this->getCacheKey();
        return $this->getStore()->forever($key, $data);
    }

    /**
     * @return bool|void
     * @throws InvalidArgumentException
     */
    public function flushCache()
    {
        if (!$this->enableCache()) {
            return;
        }
        // remove cache id model
        $keyCacheId = self::cachePrefix($this->attributes[$this->getKeyName()]);
        if ($this->getStore()->has($keyCacheId)) {
            $this->getStore()->delete($keyCacheId);
        }
        return $this->getStore()->delete($this->getCacheKey());
    }

    /**
     * @return bool
     */
    public static function enableCache()
    {
        return config('site.cache.enable');
    }

    /**
     * Get cache store.
     *
     * @return Repository
     */
    public static function getStore()
    {
        return Cache::store(config('site.cache.store', 'file'));
    }

    /**
     *
     */
    public static function bootCacheable()
    {
        static::deleted(function ($model) {
            $model->flushCache();
        });
        static::saved(function ($model) {
            $model->flushCache();
        });
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        if (!isset($this->attributes[self::getCacheField()])) {
            return self::cachePrefix();
        }
        return self::cachePrefix() . $this->attributes[self::getCacheField()];
    }

    /**
     * @param $name
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function isExitCacheByName($name) {
        if (! self::enableCache()) {
            return false;
        }
        $cacheName = self::cachePrefix($name);
        return self::getStore()->has($cacheName);
    }

    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function isExitCache() {
        if (! $this->enableCache()) {
            return false;
        }
        return $this->getStore()->has($this->getCacheKey());
    }

    /**
     * @param $name
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function getCacheByName($name, $params = [])
    {
        if (! self::enableCache()) {
            return self::getModelCacheByName($name)->makeCache($params);
        }
        if (!self::isExitCacheByName($name)) {
            $model = self::getModelCacheByName($name);
            $model->forever($model->makeCache($params));
        }
        $cacheKey = self::cachePrefix($name);
        return self::getStore()->get($cacheKey);
    }

    /**
     * @param $id
     * @param array $params
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function getCacheById($id, $params = [])
    {
        $cacheKey = self::cachePrefix($id);
        if (!self::isExitCacheByName($id)) {
            $model = self::getModelCacheById($id);
            $model->forever($model->makeCache($params), $cacheKey);
        }
        return self::getStore()->get($cacheKey);
    }

    public static function getModelCacheByName($name) {
        return self::where(self::getCacheField(), $name)->firstOrFail();
    }

    public static function getModelCacheById($id) {
        return self::findOrFail($id)->firstOrFail();
    }

    /**
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function getCache()
    {
        if (!$this->isExitCache()) {
            $this->forever($this->makeCache([]));
        }
        return $this->getStore()->get($this->getCacheKey());
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function cachePrefix($prefix = '')
    {
        $keyModel = static::getModelKey();
        return config('site.cache.keys.' . $keyModel , 'site-caches') . $prefix;
    }

    /**
     * @return string
     */
    public static function getCacheField() {
        return self::$cacheField;
    }

    /**
     * @param $params
     * @return mixed
     */
    abstract public function makeCache($params);
}
