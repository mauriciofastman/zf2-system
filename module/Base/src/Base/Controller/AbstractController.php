<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Base\Controller;

/**
 * Description of AbstractEntity
 *
 * @author mauricioschmitz
 */

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Model\ViewModel;

abstract class AbstractController extends AbstractActionController{
    
    protected $em;
    protected $entity;
    protected $controller;
    protected $route;
    protected $service;
    protected $form;
    
    /**
     * 
     * @param array $options
     */
    abstract public function __construct();
    
    /**
    * 1 - Listar registros
    */
    public function indexAction(){
        $list = $this->getEm()->getRepository($this->entity)->findAll();
        
        $page = $this->params()->fromRoute('page');
        
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
            ->setDefaultItemCountPerPage(10);
        
        return new ViewModel(array('data' => $paginator, 'page' =>$page));
    }

    /**
    * 2 - Inserir registro
    */
    public function insertAction(){
        
        if(is_string($this->form))
            $form = new $this->form;
        else 
            $form = $this->form;
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            
            if($form->isValid()){
                
                $service =$this->getServiceLocator()->get($this->service);
                
                if($service->save($request->getPost()->toArray())){
                    $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');
                } else {
                    $this->flashMessenger()->addErrorMessage('Ocorreu um erro!');  
                }
                
                return $this->redirect()->toRoute($this->route, array('controller'=>$this->controller, 'action' => 'insert'));
                
            }else{
                $this->flashMessenger()->addErrorMessage('Dados inseridos inválidos');
            }
        }
        
        if($this->flashMessenger()->hasSuccessMessages()){
            return new ViewModel(array(
                'form'=>$form, 
                'success' => $this->flashMessenger()->getSuccessMessages()
                )
            );
        }
        
        if($this->flashMessenger()->hasErrorMessages()){
            return new ViewModel(array(
                'form'=>$form, 
                'error' => $this->flashMessenger()->getErrorMessages()
                )
            );
        }
        
        $this->flashMessenger()->clearMessages();
        
        return new ViewModel(array('form'=>$form));
    }

    /**
    * 3 - Editar registro
    */
    public function editAction(){
        
        if(is_string($this->form))
            $form = new $this->form;
        else 
            $form = $this->form;
        
        $request = $this->getRequest();
        $param = $this->params()->fromRoute('id', 0);
        
        $repository = $this->getEm()->getRepository($this->entity)->find($param);
        
        if($repository){
            
            $array = array();
            foreach($repository->toArray() as $key => $value){
                if($value instanceof \DateTime){
                    $array[$key] = $value->format ('d/m/Y');
                }else {
                    $array[$key] = $value;
                }
            }
            
            $form->setData($array);
            
            if($request->isPost()){
                $form->setData($request->getPost());

                if($form->isValid()){

                    $service =$this->getServiceLocator()->get($this->service);
                    
                    $data = $request->getPost()->toArray();
                    $data['id'] = (int)$param;
                    
                    if($service->save($data)){
                        $this->flashMessenger()->addSuccessMessage('Alterado com sucesso!');
                    } else {
                        $this->flashMessenger()->addErrorMessage('Ocorreu um erro!');  
                    }

                    return $this->redirect()->toRoute($this->route, array('controller'=>$this->controller, 'action' => 'edit', 'id' => $param));

                }else{
                    $this->flashMessenger()->addErrorMessage('Dados inseridos inválidos');
                }
            }
            
        }else{
            $this->flashMessenger()->addInfoMessage('Registro não encontrado');
            return $this->redirect()->toRoute($this->route, array('controller'=>$this->controller, 'action' => 'edit', 'id' => $param));
        }
        
        if($this->flashMessenger()->hasSuccessMessages()){
            return new ViewModel(array(
                'form'=>$form, 
                'success' => $this->flashMessenger()->getSuccessMessages(),
                'id' => $param
                )
            );
        }
        
        if($this->flashMessenger()->hasErrorMessages()){
            return new ViewModel(array(
                'form'=>$form, 
                'error' => $this->flashMessenger()->getErrorMessages(),
                'id' => $param
                )
            );
        }
        
        if($this->flashMessenger()->hasInfoMessages()){
            return new ViewModel(array(
                'form'=>$form, 
                'warning' => $this->flashMessenger()->getInfoMessages(),
                'id' => $param
                )
            );
        }
        
        $this->flashMessenger()->clearMessages();
        
        return new ViewModel(array('form'=>$form, 'id' => $param));
    }

    /**
    * 4 - Excluir registro
    */
    public function deleteAction(){
        
        $service = $this->getServiceLocator()->get($this->service);
        $id = $this->params()->fromRoute('id', 0);
        
        if($service->remove(array('id' => $id))){
            $this->flashMessenger()->addSuccessMessage('Registro removido com sucesso!');
        }else{
            $this->flashMessenger()->addErrorMessage('Não foi possivel remover o registro');
        }
        
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm(){
        if($this->em == null){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        
        return $this->em;
    }
    
    
    
    
}
