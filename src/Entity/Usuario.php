<?php

namespace App\Entity;



use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Role\Role;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario implements UserInterface, \Serializable
{


	/**
	 * @ORM\Column(name="codigo_usuario_pk",type="string")
	 * @ORM\Id
	 */
	private $codigoUsuarioPk;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $correo;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $nombres;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $apellidos;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $clave;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $verificado;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $token;

	/**
	 * @ORM\Column(name="codigo_negocio_fk", type="integer", nullable=true)
	 */
	private $codigoNegocioFk;

	/**
	 * @ORM\Column(name="codigo_rol_fk", type="string", length=20, nullable=true)
	 */
	private $codigoRolFk;

    /**
     * @ORM\Column(name="control", type="boolean", nullable=true)
     */
    private $control;



	/**
	 * Se implementan métodos de la clase User del core de Symfony además de los metodos de la entidad própia.
	 *
	 */
	public function serialize()
	{
		return serialize(array(
			$this->codigoUsuarioPk,
			$this->clave
		));
	}

	public function unserialize($serialized)
	{
		list(
			$this->codigoUsuarioPk,
			$this->clave

			) = unserialize($serialized);
	}

	public function getUsername()
	{
		return $this->getCodigoUsuarioPk();
	}

	public function getRoles()
	{

        return array($this->codigoRolFk);
	}

	public function getPassword()
	{
		return $this->getClave();
	}

	public function getSalt()
	{
		return null;
	}

	public function eraseCredentials()
	{

	}

    /**
     * @return mixed
     */
    public function getCodigoUsuarioPk()
    {
        return $this->codigoUsuarioPk;
    }

    /**
     * @param mixed $codigoUsuarioPk
     */
    public function setCodigoUsuarioPk($codigoUsuarioPk): void
    {
        $this->codigoUsuarioPk = $codigoUsuarioPk;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }

    /**
     * @return mixed
     */
    public function getVerificado()
    {
        return $this->verificado;
    }

    /**
     * @param mixed $verificado
     */
    public function setVerificado($verificado): void
    {
        $this->verificado = $verificado;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCodigoNegocioFk()
    {
        return $this->codigoNegocioFk;
    }

    /**
     * @param mixed $codigoNegocioFk
     */
    public function setCodigoNegocioFk($codigoNegocioFk): void
    {
        $this->codigoNegocioFk = $codigoNegocioFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoRolFk()
    {
        return $this->codigoRolFk;
    }

    /**
     * @param mixed $codigoRolFk
     */
    public function setCodigoRolFk($codigoRolFk): void
    {
        $this->codigoRolFk = $codigoRolFk;
    }

    /**
     * @return mixed
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * @param mixed $control
     */
    public function setControl($control): void
    {
        $this->control = $control;
    }



}
