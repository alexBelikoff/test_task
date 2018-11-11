<?php
/**
 * Created by PhpStorm.
 * User: Beluha
 * Date: 11.11.2018
 * Time: 11:58
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('index.html.twig');
    }
}