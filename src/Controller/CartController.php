<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;

class CartController extends AbstractController
{
    // Affiche le contenu du panier
    #[Route('/panier', name: 'cart_index')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository): Response
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $product = $produitRepository->find($id);
            if ($product) {
                $cartWithData[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }

        $total = 0;
        foreach ($cartWithData as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total,
        ]);
    }
#[Route('/produits', name: 'produit_index')]
public function listProducts(ProduitRepository $produitRepository): Response
{
    $produits = $produitRepository->findAll();

    return $this->render('produit/index.html.twig', [
        'produits' => $produits,
    ]);
}


    // Ajoute un produit au panier
    #[Route('/panier/ajouter/{id}', name: 'cart_add')]
    public function add($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + 1; // incrémente ou initialise à 1
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    // Supprime un produit du panier
    #[Route('/panier/supprimer/{id}', name: 'cart_remove')]
    public function remove($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }
}
