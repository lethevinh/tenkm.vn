<?php

namespace App\Services;

use Countable;
use Thunder\Shortcode\HandlerContainer\HandlerContainer;
use Thunder\Shortcode\Parser\RegexParser;
use Thunder\Shortcode\Parser\WordpressParser;
use Thunder\Shortcode\Processor\Processor;
use Thunder\Shortcode\Shortcode\Shortcode;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class Shortcodes implements Countable
{
    /** @var HandlerContainer */
    protected HandlerContainer $_handlers;

    /**
     * The constructor.
     */
    public function __construct()
    {
        $this->_handlers = new HandlerContainer;
    }

    /**
     * Get all shortcodes.
     *
     * @return array
     */
    public function all()
    {
        return $this->_handlers->getNames();
    }

    public function addShortCode($name, $object, $force = false)
    {

        if (is_string($object) && class_exists($object)) {
            $this->add($name, [new $object, 'handler'], $force);
        }

        if (is_callable($object)) {
            $this->add($name, $object, $force);
        }

    }

    /**
     * Register new shortcode.
     *
     * @param string $name
     * @param callable $handler
     * @param bool $force
     * @return Shortcodes
     * @throws \Exception
     */
    public function add(string $name, callable $handler, $force = false)
    {
        if (!preg_match("/[a-z:-]+/", $name)) {
            throw new \Exception("$name is not valid shortcode name , only accept a-z:-");
        }
        if ($this->exists($name) && !$force) {
            throw new \Exception("shortcode [$name] had exists ");
        }

        $this->remove($name);

        $this->_handlers->add($name, $handler);
        return $this;
    }

    /**
     * Unregister the specified shortcode by given name.
     *
     * @param string $name
     * @return Shortcodes
     */
    public function remove(string $name)
    {
        if ($this->exists($name)) {
            $this->_handlers->remove($name);
        }
        return $this;
    }

    /**
     * Get handler by name
     *
     * Return handler registered in container
     *
     * @param string $name
     * @return callable|null
     */
    public function get(string $name)
    {
        return $this->_handlers->get($name);
    }

    /**
     * Handler shortcode
     *
     *
     * Directly handle shortcode without parsing text , this will increase performance
     * Thus increase code readability
     * We intercepting params here and make new Shortcode instance to pass it into handler
     * to satisfy interface required . All shortcode handlers must require ShortcodeInterface
     * as only arguments
     *
     * @param string $name
     * @param array $args
     * @param string $content
     * @return null|any
     */
    public function handle(string $name, array $args = [], $content = "")
    {
        $handler = $this->get($name);
        if (!$handler) {
            return null;
        }
        return call_user_func_array($handler, [new Shortcode($name, $args, $content)]);
    }

    /**
     * Process text with handlers registered
     *
     * Each process will spawn new Processor and Parser , only HandlerContainer remain persistent
     *
     * @param string $text
     * @return string
     */
    public function process(string $text)
    {
        $processor = new Processor(WordpressParser::createFromHandlers($this->_handlers), $this->_handlers);
        return $processor->process($text);
    }

    /**
     * Get all handlers name
     * @return string[]
     */
    public function names()
    {
        return $this->_handlers->getNames();
    }

    /**
     * Unregister all shortcodes.
     *
     * @return self
     */
    public function destroy()
    {
        $this->_handlers = new HandlerContainer();
        return $this;
    }

    /**
     * Strip any shortcodes.
     *
     * @param string $content
     *
     * @return string
     */
    public function strip(string $content)
    {
        $handlers = new HandlerContainer();
        $handlers->setDefault(function (ShortcodeInterface $s) {
            return $s->getContent();
        });
        $processor = new Processor(new RegexParser(), $handlers);
        return $processor->process($content);
    }

    /**
     * Get count from all shortcodes.
     *
     * @return int
     */
    public function count()
    {
        return count($this->_handlers->getNames());
    }

    /**
     * Return true is the given name exist in shortcodes array.
     *
     * @param string $name
     *
     * @return bool
     */
    public function exists(string $name)
    {
        return $this->_handlers->has($name);
    }

    /**
     * Return true is the given content contain the given name shortcode.
     *
     * @param string $content
     * @param string $name
     *
     * @return bool
     */
    public function contains(string $content, string $name)
    {
        $hasShortcode = false;
        $handlers = new HandlerContainer();
        $handlers->setDefault(function (ShortcodeInterface $s) use ($name, &$hasShortcode) {
            if ($s->getName() === $name) {
                $hasShortcode = true;
            }
        });
        $processor = new Processor(new RegexParser(), $handlers);
        $processor->process($content);
        return $hasShortcode;
    }

    /**
     * Parse content and replace parts of it using registered handlers
     *
     * @param $content
     *
     * @return string
     */
    public function parse($content)
    {
        $processor = new Processor(new RegexParser(), $this->_handlers);
        return $processor->process($content);
    }

    /**
     * Parse content and replace parts of it using registered handlers
     *
     * @param $content
     *
     * @return string
     */
    public function doShortcodes($content)
    {
        return $this->parse($content);
    }

}
