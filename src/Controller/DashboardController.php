<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Petdb\User;
use App\Entity\Petdb\UserSearch;
use App\Form\UserSearchType;

class DashboardController extends ApiController
{
    
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        
        // Search
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        // dd($search);

        $em = $this->getDoctrine()->getManager('customer');
        // On passe la recherche
        $query = $em->getRepository(User::class)->findWithSearchQuery($search);
        // $dql   = "SELECT u FROM App\Entity\Petdb\User u";
        // $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $loggedUser = $this->getUser();

        return $this->render('dashboard/users.html.twig', [
            'loggedUser' => $loggedUser,
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }

    public function pets(Request $request, SessionInterface $session)
    {
        
        $loggedUser = $this->getUser();
        // dd($user);

        return $this->render('dashboard/pets.html.twig', [
            'loggedUser' => $loggedUser
        ]);
    }

    public function connexions(Request $request, SessionInterface $session)
    {
        
        $loggedUser = $this->getUser();
        // dd($user);

        return $this->render('dashboard/connexions.html.twig', [
            'loggedUser' => $loggedUser
        ]);
    }
    
}
