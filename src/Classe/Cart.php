<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

    private $session;

    //on créée une session pour le panier
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * Fonction d'ajout au panier
     * @param $id
     */
    public function add($id)
    {

        $cart = $this->session->get('cart', []);


        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }


        $this->session->set('cart', $cart);
    }

    /**
     * Fonction pour récupérer le panier
     */
    public function get()
    {
        return $this->session->get('cart');
    }

    /**
     * Fonction pour récupérer le panier
     */
    public function remove(Cart $cart)
    {
        return $this->session->remove('cart');
    }
}
