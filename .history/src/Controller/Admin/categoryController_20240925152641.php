<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;


#[Route("/admin/category", name: 'admin.category')]
class CategoryController extends AbstractController {

    #[Route(name: 'index')]
    public function index() {
        
    }
    #[Route("/create", name: 'create')]
    public function create() {
        
    }
    #[Route("/{id}", name: 'edit', requirements : ['id' => Requirements::Digits], methods:['GET', 'POST'])]
    public function edit() {
        
    }
    #[Route("/{id}", name: 'delete', requirements : ['id' => Requirements::Digits], methods: ['DELETE'])]
    public function remove() {
        
    }
}
