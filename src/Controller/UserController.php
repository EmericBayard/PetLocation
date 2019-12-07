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
use App\Form\UserEditType;
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
    // $day = $params['day'];
    $day = $params['period'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE createdAt > :day AND createdAt < :day + INTERVAL 1 DAY";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("day", $day);
    $statement->execute();
    $result = $statement->fetchAll();
    // dd($result);
    return $this->responseApi($result);
    
  }

  public function getnewUserNumberByWeek(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $day = $params['period'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE createdAt > :day AND createdAt < :day + INTERVAL 7 DAY";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("day", $day);
    $statement->execute();
    $result = $statement->fetchAll();
    // dd($result);
    return $this->responseApi($result);
    
  }

  public function getnewUserNumberByMonth(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $day = $params['period'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE createdAt > :day AND createdAt < :day + INTERVAL 1 MONTH";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("day", $day);
    $statement->execute();
    $result = $statement->fetchAll();
    // dd($result);
    return $this->responseApi($result);
    
  }

  public function getnewUserNumberByYear(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $day = $params['period'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE createdAt > :day AND createdAt < :day + INTERVAL 1 YEAR";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("day", $day);
    $statement->execute();
    $result = $statement->fetchAll();
    // dd($result);
    return $this->responseApi($result);
    
  }

  // Count users by place
  public function getNbUsersByCity(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $place = $params['place'];

    $em = $this->getDoctrine()->getManager('customer');

    $query = "SELECT COUNT(*) FROM user WHERE city = :place";

    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("place", $place);
    $statement->execute();
    $result = $statement->fetchAll();

    return $this->responseApi($result);
  }

  public function getNbUsersByZip(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $place = $params['place'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE zip = :place";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("place", $place);
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $this->responseApi($result);
  }

  public function getNbUsersByCountry(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $place = $params['place'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE country = :place";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("place", $place);
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $this->responseApi($result);
  }

  public function getNbUsersBySex(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $sex = $params['sex'];

    $em = $this->getDoctrine()->getManager('customer');
    $query = "SELECT COUNT(*) FROM user WHERE sexe = :sex";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("sex", $sex);
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $this->responseApi($result);
  }
  
  public function getNbUsersByActive(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $active = $params['active'];

    $em = $this->getDoctrine()->getManager('customer');

    $query = "SELECT COUNT(*) FROM user WHERE active = :active";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("active", $active);
    $statement->execute();
    $result = $statement->fetchAll();
    
    return $this->responseApi($result);
  }
  
  public function getNbSubscriptionsUsersByActive(Request $request, EntityManagerInterface $em) {

    $content = $request->getContent();
    $params = json_decode($content, true);
    $active = $params['active'];

    $em = $this->getDoctrine()->getManager('customer');

    $query = "SELECT COUNT(*) FROM billing INNER JOIN user ON user_iduser = iduser WHERE billing.dateBilling < CURRENT_DATE AND user.active = :active";
    $statement = $em->getConnection()->prepare($query);
    $statement->bindValue("active", $active);
    $statement->execute();
    $result = $statement->fetchAll();
    
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
      $form = $this->createForm(UserEditType::class, $user);
      $form->handleRequest($request);

      if ($request->isXmlHttpRequest()) {
        //you can get status directly with this
        // $request->get('status');
        //Do some stuff... 
      }

      if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        
        $plainPassword = $form->get('plainPassword')->getData();
        // dump($plainPassword);
        if ($plainPassword != '') {
          $user->setPassword($encoder->encodePassword($user, $plainPassword));
        }
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

    public function removeUser(Request $request, EntityManagerInterface $em, $id) {
      
      $loggedUser = $this->getUser();

      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager('customer');
        $user = $em->getRepository(User::class)->find($id);
        // dd($user); 
        $em->remove($user);
        $em->flush();

        $result = [
          'message' => 'user removed'
        ];
        
        return $this->responseApi($result);

        // return $this->render('dashboard/remove-user.html.twig', [
        //   'loggedUser' => $loggedUser
        // ]);

      }
    }

}