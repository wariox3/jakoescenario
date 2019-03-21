<?php

namespace App\Controller;


use App\Entity\Obligacion;
use App\Entity\Vigencia;
use App\Entity\Norma;
use App\Form\Type\ObligacionType;
use App\Form\Type\NormaType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Mensajes;
use function PHPSTORM_META\type;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class EscenarioController extends Controller
{

    /**
     * @Route("/admin/norma/lista", name="norma_lista")
     */
    public function lista(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $form = $this->createFormBuilder()
            ->add('codigo', NumberType::class, ['required' => false, 'data' => $session->get('filtroNormaCodigo')])
            ->add('nombre', TextType::class, ['required' => false, 'data' => $session->get('filtroNormaNombre')])
            ->add('descripcion', TextType::class, ['required' => false, 'data' => $session->get('filtroNormaDescripcion')])
            ->add('estadoDerogado', ChoiceType::class, ['choices' => ['TODOS' => '', 'SI' => '1', 'NO' => '0'], 'data' => $session->get('filtroNormaEstadoDerogado'), 'required' => false])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-default']])
            ->add('btnEliminar', SubmitType::class, ['label' => 'Eliminar', 'attr' => ['class' => 'btn btn-sm btn-default']])

            ->getForm();
        $form->handleRequest($request);
        $arNormas = $paginator->paginate($em->getRepository(Norma::class)->lista(), $request->query->getInt('page', 1), 500);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                $session->set('filtroNormaEstadoDerogado', $form->get('estadoDerogado')->getData());
                $session->set('filtroNormaCodigo', $form->get('codigo')->getData());
                $session->set('filtroNormaNombre', $form->get('nombre')->getData());
                $session->set('filtroNormaDescripcion', $form->get('descripcion')->getData());
            }

            if($form->get('btnEliminar')->isClicked()){
                $arrSeleccionados = $request->request->get('ChkSeleccionar');
                $em->getRepository(Norma::class)->eliminar($arrSeleccionados);
                return $this->redirect($this->generateUrl('norma_lista'));
            }
        }
        return $this->render('Norma/lista.html.twig', [
            'arNormas' => $arNormas,
            'form' => $form->createView()
        ]);
    }


}
