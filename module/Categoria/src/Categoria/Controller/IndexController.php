<?php
namespace Categoria\Controller;

use Base\Controller\AbstractController;


/**
 * Description of IndexController
 *
 * @author mauriciohimaker
 */
class IndexController extends AbstractController{
    
    public function __construct() {
        $this->form = 'Categoria\Form\CategoryForm';
        $this->controller = 'Categoria';
        $this->route = 'categoria/default';
        $this->service = 'Categoria\Service\CategoriaService';
        $this->entity = 'Categoria\Entity\Category';
    }
    
}
