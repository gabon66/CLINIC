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
use ApiBundle\Entity\Medicion;

class MedicionesController extends Controller
{
    public function getMedicionAction($key,$value){

        $em = $this->getDoctrine()->getEntityManager();

        $repoPat =$em->getRepository('ApiBundle\Entity\Medicion');

        $med = $repoPat->findBy(array($key=>$value));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($med,"json"),200,array('Content-Type'=>'application/json'));
    }

    public function getMedicionesAction(){

        $em = $this->getDoctrine()->getEntityManager();

        $repoPat =$em->getRepository('ApiBundle\Entity\Medicion');

        $meds = $repoPat->findAll();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($meds,"json"),200,array('Content-Type'=>'application/json'));
    }



    public function setMedicionAction(\Symfony\Component\HttpFoundation\Request $request){

        $em = $this->getDoctrine()->getEntityManager();

        $content = $request->getContent();
        if (!empty($content))
        {
            $content = json_decode($content, true); // 2nd param to get as array
        }

        if (array_key_exists("id",$content)){
            $repoMed =$em->getRepository('ApiBundle\Entity\Medicion');
            $medicion = $repoMed->findOneBy(array("id"=>$content["id"]));
        }else{
            $medicion= new Medicion();
        }

        $medicion->setIdPatient($content["id_patient"]);
        $medicion->setIdDevice($content["id_device"]);
        $medicion->setData(json_encode($content["data"]));

        if (!array_key_exists("id",$content)) {
            $em->persist($medicion);
        }
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($medicion,"json"),200,array('Content-Type'=>'application/json'));
    }



    public function deleteMedicionAction(\Symfony\Component\HttpFoundation\Request $request){

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize(array("delete"=>true),"json"),200,array('Content-Type'=>'application/json'));
    }



}
