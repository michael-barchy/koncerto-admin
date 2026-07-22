<?php

namespace KoncertoAdmin\Model;

use ReflectionClass;

class MenuItem
{
    /** @var int */
    public static $MENU_ITEM = 0;
    /** @var int */
    public static $CATEGORY = 1;

    /**
     * @param class-string|string|null $className
     * @param ?string $label
     * @param ?string $icon
     * @param int $type
     * @param ?string $url
     */
    public function __construct(
        $className = null,
        $label = null,
        $icon = null,
        $type = null,
        $url = null
    ) {
        $shortName = null === $className ? null : explode('\\', $className);

        $this->className = $className;
        $this->label = null === $label && null !== $shortName ? array_pop($shortName) : $label;
        $this->icon = $icon;
        $this->type = null === $type ? MenuItem::$MENU_ITEM : $type;
        $this->url = $url;
    }

    /** @var class-string|string|null */
    public $className;

    /** @var ?string */
    public $label;

    /** @var ?string */
    public $icon;

    /** @var int */
    public $type;

    /** @var ?string */
    public $url;

    /**
     * @return string
     */
    public function getLink()
    {
        if (null !== $this->className) {
            $shortName = explode('\\', $this->className);
            $shortName = array_pop($shortName);
            $prefix = is_string($_SERVER['APP_PREFIX']) ? $_SERVER['APP_PREFIX'] : '';

            return $prefix . '/admin/' . strtolower($shortName) . '/';
        }

        return null === $this->url ? 'javascript:;' : $this->url;
    }
}
