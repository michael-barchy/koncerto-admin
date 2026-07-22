<?php

namespace KoncertoAdmin\Controller;

use Koncerto\Koncerto;
use Koncerto\KoncertoAnnotation as K;
use Koncerto\KoncertoImpulsusController;
use Koncerto\KoncertoResponse;
use KoncertoAdmin\Model\MenuItem;

class KoncertoAdminController extends KoncertoImpulsusController
{
    /** @var array<int, MenuItem> */
    private $menuItems = array();

    /**
     * @param Koncerto $koncerto
     */
    public function __construct($koncerto)
    {
        parent::__construct($koncerto);
    }

    /**
     * @see K::route() {"name": "/admin/"}
     * @return KoncertoResponse
     */
    public function admin()
    {
        $dir = str_replace($this->getDocumentRoot(), '', __DIR__);
        $current = $this->getCurrentMenuItem();

        return $this->render($dir . '/../../templates/admin.tbs.html', array(
            'title' => 'Home',
            'menu' => $this->menuItems,
            'current' => $current ? $current->getLink() : null
        ));
    }

    /**
     * @see K::route() {"name": "/admin/%s/"}
     * @param string[] $args
     * @return KoncertoResponse
     */
    public function entity($args = array())
    {
        $dir = str_replace($this->getDocumentRoot(), '', __DIR__);
        $current = $this->getCurrentMenuItem();
        $fields = array();
        $rows = array();
        if ($current && null !== $current->className && class_exists($current->className, true)) {
            $em = $this->getEntityManager();
            $describe = $em->describe($current->className);
            $rows = $em->findAll($current->className);
            $rows = array_map(function ($e) {
                return (array)$e;
            }, $rows);
            $first = count($rows) ? $rows[0] : null;
            $fields = is_array($first) ? array_keys($first) : array_keys($describe);
        }

        return $this->render($dir . '/../../templates/list.tbs.html', array(
            'title' => ucfirst($args[0]),
            'menu' => $this->menuItems,
            'current' => $current ? $current->getLink() : null,
            'fields' => $fields,
            'rows' => $rows
        ));
    }

    /**
     * @param MenuItem $menuItem
     * @return void
     */
    public function addMenuItem($menuItem)
    {
        array_push($this->menuItems, $menuItem);
    }

    /**
     * @return ?MenuItem
     */
    public function getCurrentMenuItem()
    {
        $pathInfo = $this->getRequest()->getPathInfo();
        $items = array_filter($this->menuItems, function ($item) use ($pathInfo) {
            return $pathInfo === $item->getLink();
        });

        return array_shift($items);
    }
}
