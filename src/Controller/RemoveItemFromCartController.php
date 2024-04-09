<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RemoveItemFromCartController extends AbstractController
{
    #[Route('/remove/item/from/cart', name: 'app_remove_item_from_cart')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RemoveItemFromCartController.php',
        ]);
    }
}
