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
     */
    public function __construct(
        $className = null,
        $label = null,
        $icon = null,
        $type = null
    ) {
        $shortName = null === $className ? null : explode('\\', $className);

        $this->className = $className;
        $this->label = null === $label && null !== $shortName ? array_pop($shortName) : $label;
        $this->icon = $icon;
        $this->type = null === $type ? MenuItem::$MENU_ITEM : $type;
    }

    /** @var int */
    public $type;

    /** @var class-string|string|null */
    public $className;

    /** @var ?string */
    public $label;

    /** @var ?string */
    public $icon;
}
