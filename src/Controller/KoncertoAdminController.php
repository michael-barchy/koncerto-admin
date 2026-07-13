<?php

namespace KoncertoAdmin\Controller;

use Koncerto\KoncertoImpulsusController;
use Koncerto\KoncertoAnnotation as K;

class KoncertoAdminController extends KoncertoImpulsusController
{
    /**
     * @see K::route() {"name": "/admin/"}
     * @return KoncertoResponse
     */
    public function admin()
    {
        $dir = str_replace($this->getDocumentRoot(), '', __DIR__);
        return $this->render($dir . '/../../templates/admin.tbs.html');
    }
}
