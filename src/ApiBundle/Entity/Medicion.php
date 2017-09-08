<?php

namespace ApiBundle\Entity;

/**
 * Medicion
 */
class Medicion
{
    /**
     * @var int
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var integer
     */
    private $id_patient;

    /**
     * @var json
     */
    private $data;


    /**
     * Set idPatient
     *
     * @param integer $idPatient
     *
     * @return Medicion
     */
    public function setIdPatient($idPatient)
    {
        $this->id_patient = $idPatient;

        return $this;
    }

    /**
     * Get idPatient
     *
     * @return integer
     */
    public function getIdPatient()
    {
        return $this->id_patient;
    }



    /**
     * Set data
     *
     * @param string $data
     *
     * @return Medicion
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * @var integer
     */
    private $id_device;


    /**
     * Set idDevice
     *
     * @param integer $idDevice
     *
     * @return Medicion
     */
    public function setIdDevice($idDevice)
    {
        $this->id_device = $idDevice;

        return $this;
    }

    /**
     * Get idDevice
     *
     * @return integer
     */
    public function getIdDevice()
    {
        return $this->id_device;
    }
}
