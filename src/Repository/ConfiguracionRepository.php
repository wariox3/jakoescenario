<?php

namespace App\Repository;

use App\Entity\Configuracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ConfiguracionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Configuracion::class);
    }

    public function urlServicio()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(Configuracion::class, "c")
            ->select("c.urlServicio")
            ->where("c.codigoConfiguracionPk = 1");
        $arConfiguracion =  $qb->getQuery()->getResult();
        return $arConfiguracion[0]["urlServicio"];

    }
}