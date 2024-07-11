<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Customer;
use App\Form\AccountType;
use App\Repository\CustomerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EamenController extends AbstractController
{
    #[Route('/eamen', name: 'app_eamen')]
    public function index(): Response
    {
        return $this->render('eamen/index.html.twig', [
            'controller_name' => 'EamenController',
        ]);
    }
    #[Route('/st', name: 'st')]
    public function fetchStudents(CustomerRepository $repo)
    {
        $studnets = $repo->findAll();
        return $this->render('customer/listCustomer.html.twig', [
            's' => $studnets
        ]);
    }
    #[Route('/add/{id}', name: 'add')]
    public function addaccount(Request $req, ManagerRegistry $mr,Customer $c)
    {
        $account = new Account();
        $f = $this->createForm(AccountType::class, $account);
        $f->handleRequest($req);
        if($f->isSubmitted()){
            $account->setCreatedAt( new \DateTimeImmutable('now'));
            $account->setCust($c);
        $em = $mr->getManager();
        $em->persist($account);
        $em->flush();
    }
        return $this->renderForm("customer/addacount.html.twig", [
            'formaccount' => $f,
            'informationsuruser'=>$c
        ]);
    }
}
