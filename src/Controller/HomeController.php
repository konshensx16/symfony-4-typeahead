<?php

namespace App\Controller;

use App\Entity\Cities;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    public function searchBar()
    {
        $form = $this->createFormBuilder(null)
                ->setAction($this->generateUrl('handle_search'))
                ->add("query", TextType::class, [
                    'attr' => [ 
                        'placeholder'   => 'Enter search query...'
                    ]
                ])
                ->add("submit", SubmitType::class)
            ->getForm()
        ;

        return $this->render('search/search.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleSearch/{_query?}", name="handle_search", methods={"POST", "GET"})
     */
    public function handleSearchRequest(Request $request, $_query)
    { 
        $em = $this->getDoctrine()->getManager();

        if ($_query)
        {
            $data = $em->getRepository(Cities::class)->findByName($_query);
        } else {            
            $data = $em->getRepository(Cities::class)->findAll();
        }

        // iterate over all the resuls and 'inject' the image inside
        for ($index = 0; $index < count($data); $index++)
        {
            $object = $data[$index];
            // http://via.placeholder.com/35/0000FF/ffffff
            $object->setImage("http://via.placeholder.com/35/0000FF/ffffff");
        }

        // setting up the serializer 
        $normalizers = [
            new ObjectNormalizer()
        ];

        $encoders =  [
            new JsonEncoder()
        ];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $serializer->serialize($data, 'json');

        return new JsonResponse($data, 200, [], true);
    }   


    /**
    * @Route("/city/{id?}", name="city_page", methods={"GET"})
    */
    public function citySingle(Request $request, $id)
    { 
        $em = $this->getDoctrine()->getManager();
        $city = null; 
 
        if ($id) {
            $city = $em->getRepository(Cities::class)->findOneBy(['id' => $id]);
        } 

        return $this->render('home/city.html.twig', [
            'city'  =>      $city
        ]);
    }   

} 