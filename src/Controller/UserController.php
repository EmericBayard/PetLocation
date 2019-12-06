<?php 

namespace App\Controller;

use App\Entity\Petdb\User;
use App\Entity\Petdb\Token;
use App\Entity\Mydb\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\UserAddType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends ApiController {

  public function getUsers(EntityManagerInterface $em): Response {
      $em = $this->getDoctrine()->getManager('customer');
      $users = $em->getRepository(User::class)->find(1);
      dd($users);
  }

  public function getAdmins(EntityManagerInterface $em): Response {
      $em = $this->getDoctrine()->getManager('default');
      $admins = $em->getRepository(Admin::class)->findAll();
      dd($admins);
  }

  public function getUsersCount(EntityManagerInterface $em): Response {
      $em = $this->getDoctrine()->getManager('customer');
      $nb = $em->getRepository(User::class)->getUsersCount();
      return $this->responseApi($nb);
  }

  public function getnewUserNumberByDay(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $day = $params['day'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE createdAt > :day AND createdAt < :day + INTERVAL 1 DAY";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("day", $day);
    $statement->execute();
    $result = $statement->fetchAll();
    // dd($result);
    return $this->responseApi($result);
    
  }

  public function getUserByAge(Request $request, EntityManagerInterface $em) {

    // $content = $request->getContent();
    // $params = json_decode($content, true);
    // $day = $params['day'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = '
      SELECT COUNT(*)
              FROM user
              WHERE FLOOR(datediff(now(), user.birthday )) > (18*365.25)
              UNION
              SELECT COUNT(*)
              FROM user
              WHERE FLOOR(datediff(now(), user.birthday )) >= (18*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (25*365.25)
              UNION
              SELECT COUNT(*)
              FROM user
              WHERE FLOOR(datediff(now(), user.birthday )) >= (26*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (35*365.25)
              UNION
              SELECT COUNT(*)
              FROM user
              WHERE FLOOR(datediff(now(), user.birthday )) >= (36*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (50*365.25)
              UNION
              SELECT COUNT(*)
              FROM user
              WHERE FLOOR(datediff(now(), user.birthday )) > (50*365.25)
      ';
    $statement = $em->getConnection()->prepare($query);
    // $statement->bindValue("day", $day);
    $statement->execute();
    $result = $statement->fetchAll();

    $list = [];
    foreach ($result as $item){
        foreach ($item as $value) {
          dump($value);
          array_push($list, $value);
        }
    }

    // dd($list);
    return $this->responseApi($result);
    
  }

  public function getByAges() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) > (18*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) >= (18*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (25*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) >= (26*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (35*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) >= (36*365.25) AND FLOOR(datediff(now(), user.birthday )) <= (50*365.25)
                UNION
                SELECT COUNT(*)
                FROM user
                WHERE FLOOR(datediff(now(), user.birthday )) > (50*365.25)
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function addUser(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder) {

      $loggedUser = $this->getUser();
      $user = new User();

      $form = $this->createForm(UserAddType::class, $user);
      $form->handleRequest($request);

      if ($request->isXmlHttpRequest()) {
        //you can get status directly with this
        // $request->get('status');
        //Do some stuff... 
      }

      if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
          // dd($user);
        $em = $this->getDoctrine()->getManager('customer');
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('dashboard');
      }

      return $this->render('dashboard/add-user.html.twig', [
        'form' => $form->createView(),
        'loggedUser' => $loggedUser
      ]);
    }

    public function editUser(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, $id) {

      $loggedUser = $this->getUser();
      // $user = new User();
      $em = $this->getDoctrine()->getManager('customer');
      $user = $em->getRepository(User::class)->find($id);
      // dd($user);
      $form = $this->createForm(UserAddType::class, $user);
      $form->handleRequest($request);

      if ($request->isXmlHttpRequest()) {
        //you can get status directly with this
        // $request->get('status');
        //Do some stuff... 
      }

      if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        $encoded = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
          // dd($user);
        $em = $this->getDoctrine()->getManager('customer');
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('dashboard');
      }

      return $this->render('dashboard/edit-user.html.twig', [
        'form' => $form->createView(),
        'loggedUser' => $loggedUser
      ]);
    }

}