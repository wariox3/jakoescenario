<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRepository")
 */
class Configuracion
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_configuracion_pk", type="string", length=2)
     */
    private $codigoConfiguracionPk = 1;

    /**
     * @ORM\Column(name="url_servicio", type="string", length=100, nullable=true)
     */
    private $urlServicio;

    /**
     * @return mixed
     */
    public function getCodigoConfiguracionPk()
    {
        return $this->codigoConfiguracionPk;
    }

    /**
     * @param mixed $codigoConfiguracionPk
     */
    public function setCodigoConfiguracionPk($codigoConfiguracionPk): void
    {
        $this->codigoConfiguracionPk = $codigoConfiguracionPk;
    }

    /**
     * @return mixed
     */
    public function getUrlServicio()
    {
        return $this->urlServicio;
    }

    /**
     * @param mixed $urlServicio
     */
    public function setUrlServicio($urlServicio): void
    {
        $this->urlServicio = $urlServicio;
    }



}

