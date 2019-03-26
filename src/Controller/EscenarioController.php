<?php

namespace App\Controller;


use App\Entity\Configuracion;
use App\Entity\Obligacion;
use App\Entity\Vigencia;
use App\Entity\Norma;
use App\Form\Type\ObligacionType;
use App\Form\Type\NormaType;
use App\Form\Type\VigenciaType;
use App\Utilidades\Mensajes;
use function PHPSTORM_META\type;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
     * @Route("/escenario/lista", name="escenario_lista")
     */
    public function lista(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $arEscenarios = null;
        $form = $this->createFormBuilder()
            ->add('fecha', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => ['class' => 'date form-control',], 'data' => new \DateTime('now'), 'required' => true])
            ->add('btnFiltrar', SubmitType::class, ['label' => 'Filtrar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnFiltrar')->isClicked()) {
                if($this->getUser()->getCodigoNegocioFk()) {
                    $fecha = $form->get('fecha')->getData()->format('Y-m-d');
                    $url = $em->getRepository(Configuracion::class)->urlServicio();
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_POST => 1,
                        CURLOPT_URL => $url . '/v1/escenario/reserva',
                        CURLOPT_POSTFIELDS => json_encode([
                            'negocio' => $this->getUser()->getCodigoNegocioFk(),
                            'fecha' => $fecha
                        ])
                    ));
                    $arEscenarios = json_decode(curl_exec($curl), true);
                } else {
                    Mensajes::error("El usuario no tiene configurado negocio");
                }
            }
        }


        return $this->render('escenario/lista.html.twig', [
            'arEscenarios' => $arEscenarios,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/escenario/reserva/{id}", name="escenario_reserva")
     */
    public function reserva(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()
            ->add('fechaDesde', DateTimeType::class, ['format' => 'yyyy-MM-dd HH:mm', 'data' => new \DateTime('now'), 'required' => true])
            ->add('fechaHasta', DateTimeType::class, ['format' => 'yyyy-MM-dd HH:mm', 'data' => new \DateTime('now'), 'required' => true])
            ->add('btnGuardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-secondary']])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('btnGuardar')->isClicked()) {
                $fechaDesde = $form->get('fechaDesde')->getData();
                $fechaHasta = $form->get('fechaHasta')->getData();
                $url = $em->getRepository(Configuracion::class)->urlServicio();
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_POST => 1,
                    CURLOPT_URL => $url . '/v1/reserva/nuevo',
                    CURLOPT_POSTFIELDS => json_encode([
                        'escenario' => $id,
                        'jugador' => "",
                        'fecha_desde' => $fechaDesde->format('Y-m-d H:i'),
                        'fecha_hasta' => $fechaDesde->format('Y-m-d H:i')
                    ])
                ));
                $resultado = json_decode(curl_exec($curl), true);
                echo "<script languaje='javascript' type='text/javascript'>window.close();window.opener.location.reload();</script>";
            }
        }
        return $this->render('escenario/reserva.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
