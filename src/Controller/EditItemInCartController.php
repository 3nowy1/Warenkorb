<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EditItemInCartController extends AbstractController
{
    #[Route('/edit/item/in/cart', name: 'app_edit_item_in_cart')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EditItemInCartController.php',
        ]);
    }
}
