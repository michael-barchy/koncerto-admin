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

        return $this->render($dir . '/../../templates/admin.tbs.html', array(
            'menu' => $this->menuItems
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
}
