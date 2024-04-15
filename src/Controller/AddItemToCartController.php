<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AddItemToCartController extends AbstractController
{
    #[Route('/add/item/to/cart', name: 'app_add_item_to_cart')]
    public function index(): JsonResponse
    {
        return 'tut';
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AddItemToCartController.php',
        ]);
    }
}
