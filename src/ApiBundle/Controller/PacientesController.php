<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Session;

use ApiBundle\Entity\Paciente;



class PacientesController extends Controller
{


    public function mailReporteAction(\Symfony\Component\HttpFoundation\Request $request){


        $em = $this->getDoctrine()->getEntityManager();

        $content = $request->getContent();
        if (!empty($content))
        {
            $content = json_decode($content, true); // 2nd param to get as array
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Report e-health')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($content["mail"])
            ->setBody(
                $this->renderView(
                    'PortalBundle:Default:mail.html.twig',
                    array('nombre'=>$content['nombre'],'date'=>$content['date'],'items'=>$content['items'])
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize(array("process"=>true),"json"),200,array('Content-Type'=>'application/json'));

    }

    public function getPacienteAction($key,$value){

        $em = $this->getDoctrine()->getEntityManager();

        $repoPat =$em->getRepository('ApiBundle\Entity\Paciente');

        $paciente = $repoPat->findOneBy(array($key=>$value));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($paciente,"json"),200,array('Content-Type'=>'application/json'));
    }

    public function getPacientesAction(){

        $em = $this->getDoctrine()->getEntityManager();

        $repoPat =$em->getRepository('ApiBundle\Entity\Paciente');

        $pacientes = $repoPat->findAll();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($pacientes,"json"),200,array('Content-Type'=>'application/json'));
    }


    public function setPacienteAction(\Symfony\Component\HttpFoundation\Request $request){

        $em = $this->getDoctrine()->getEntityManager();

        $content = $request->getContent();
        if (!empty($content))
        {
            $content = json_decode($content, true); // 2nd param to get as array
        }

        if (array_key_exists("id",$content)){
            $repoPat =$em->getRepository('ApiBundle\Entity\Paciente');
            $patient = $repoPat->findOneBy(array("id"=>$content["id"]));
        }else{
            $patient= new Paciente();
        }

        $patient->setDni($content["dni"]);
        $patient->setMail($content["mail"]);
        $patient->setData(json_encode($content["data"]));

        if (!array_key_exists("id",$content)) {
            $em->persist($patient);
        }
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($patient,"json"),200,array('Content-Type'=>'application/json'));

    }

    public function deletePacienteAction(\Symfony\Component\HttpFoundation\Request $request){

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize(array("delete"=>true),"json"),200,array('Content-Type'=>'application/json'));

    }

}
