<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace GM\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{

    
    public function indexAction(){

        return $this->render('GMCoreBundle:Core:index.html.twig');



    }




}
