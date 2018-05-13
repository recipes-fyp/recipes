<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Psr\Log\LoggerInterface;

class MyBaseController extends Controller {

	private $logger;
	public $em;	// entity manager
	public $rm;	// repository manager
	
	public function __construct(string $repoName=null) {
		// $this->get("logger");
		// $this->log("monolog started");
		// parent::__construct();

		// this is causing errors
		// if($repoName) {
		// 	$this->em = $this->getDoctrine()->getManager();
		// 	$this->rm = $this->getDoctrine()->getRespository($repoName);
		// }

	}

    public function save($object) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();
    }

	public function log($msg) {
		// $this->logger->log($msg);
	}


}
