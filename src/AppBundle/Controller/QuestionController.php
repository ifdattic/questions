<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class QuestionController extends Controller
{
    /**
     * @Route("/")
     * @Route("/questions")
     */
    public function listAction()
    {
        $questions = $this->getDoctrine()
            ->getRepository('AppBundle:Question')
            ->getQuestions()
        ;

        return $this->render('question/list.html.twig', [
            'questions' => $questions,
        ]);
    }
}
