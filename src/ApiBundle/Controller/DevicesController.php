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
use ApiBundle\Entity\Device;

class DevicesController extends Controller
{
    public function getDeviceAction($key,$value){

        $em = $this->getDoctrine()->getEntityManager();

        $repoDev =$em->getRepository('ApiBundle\Entity\Device');

        $dev = $repoDev->findOneBy(array($key=>$value));

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($dev,"json"),200,array('Content-Type'=>'application/json'));
    }

    public function getDevicesAction(){

        $em = $this->getDoctrine()->getEntityManager();

        $repo =$em->getRepository('ApiBundle\Entity\Device');

        $devices = $repo->findAll();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($devices,"json"),200,array('Content-Type'=>'application/json'));
    }

    public function setDeviceAction(\Symfony\Component\HttpFoundation\Request $request){

        $em = $this->getDoctrine()->getEntityManager();


        $content = $request->getContent();
        if (!empty($content))
        {
            $content = json_decode($content, true); // 2nd param to get as array
        }

        if (array_key_exists("id",$content)){
            $repo =$em->getRepository('ApiBundle\Entity\Device');
            $dev = $repo->findOneBy(array("id"=>$content["id"]));
        }else{
            $dev= new Device();
        }

        $dev->setMac($content["mac"]);
        $dev->setData(json_encode($content["data"]));

        if (!array_key_exists("id",$content)) {
            $em->persist($dev);
        }
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize($dev,"json"),200,array('Content-Type'=>'application/json'));
    }


    public function deleteDeviceAction(\Symfony\Component\HttpFoundation\Request $request){

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        return new Response($serializer->serialize(array("delete"=>true),"json"),200,array('Content-Type'=>'application/json'));

    }
}
