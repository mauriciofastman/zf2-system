<?php

namespace Portfolio\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{
    public function __construct() {
        $this->form = 'Portfolio\Form\Portfolio';
        $this->controller = 'Portfolio';
        $this->route = 'portfolio/default';
        $this->service = 'Portfolio\Service\PortfolioService';
        $this->entity = 'Portfolio\Entity\Portfoli';
    }
    public function indexAction()
    {
        return new ViewModel();
    }

}
