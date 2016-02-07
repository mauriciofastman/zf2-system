<?php

namespace Login\Controller;

use Base\Controller\AbstractController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{
    public function __construct() {
        $this->form = 'Login\Form\LoginForm';
        $this->controller = 'Categoria';
        $this->route = 'categoria/default';
        $this->service = 'Categoria\Service\CategoriaService';
        $this->entity = 'Categoria\Entity\Category';
    }
    public function indexAction()
    {
        return new ViewModel();
    }

}
