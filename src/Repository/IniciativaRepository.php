<?php

namespace App\Repository;

use App\Entity\Clase;
use App\Entity\Iniciativa;
use App\Entity\ODS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Iniciativa>
 */
class IniciativaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Iniciativa::class);
    }

    public function findByEliminado()
    {
        return $this->findBy(['eliminado' => true]);
    }

    public function findByActivas()
    {
        return $this->findBy(['eliminado' => false]);
    }

    public function findByInnovadoras()
    {
        return $this->findBy(['innovador' => true]);
    }

    public function findByNoInnovadoras()
    {
        return $this->findBy(['innovador' => false]);
    }

    public function findAniosLectivos(): array
    {
        return $this->createQueryBuilder('i')
            ->select('DISTINCT i.anyoLectivo') // Asegura que no haya duplicados
            ->orderBy('i.anyoLectivo', 'DESC')
            ->getQuery()
            ->getSingleColumnResult();
    }

    /**
     * Obtiene el número de iniciativas por año lectivo
     */
    public function countIniciativasPorAnio(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.anyoLectivo, COUNT(i.id) AS total')
            ->groupBy('i.anyoLectivo')
            ->orderBy('i.anyoLectivo', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getIniciativasConCiclosYModulos(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.id AS iniciativa_id, i.nombre AS iniciativa_nombre, 
                      cl.id AS clase_id, 
                      cl.nombre AS nombre_clase, 
                      m.id AS modulo_id, 
                      m.nombre AS nombre_modulo')
            ->join('i.modulos', 'im')
            ->join('im.modulo', 'm')
            ->join('m.moduloClases', 'mc')
            ->join('mc.clase', 'cl')
            ->orderBy('i.id', 'ASC')
            ->addOrderBy('cl.id', 'ASC')
            ->addOrderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    public function getODStrabajadosYSusMetas(): array
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.metas', 'm')
            ->leftJoin('m.ods', 'o')
            ->addSelect('m', 'o')
            ->getQuery()
            ->getResult();
    }
    
    public function findOdsYSusMetas(): array
    {
        return $this->createQueryBuilder('i')
            ->select(
                'i.id AS iniciativa_id',
                'i.nombre AS iniciativa_nombre',
                'ods.id AS ods_id',
                'ods.nombre AS ods_nombre',
                'm.id AS meta_id',
                'm.descripcion AS meta_nombre'
            )
            ->leftJoin('i.metasIniciativas', 'im') // tabla intermedia
            ->leftJoin('im.idMetas', 'm')            // relación desde la intermedia a meta
            ->leftJoin('m.ods', 'ods')            // relación desde meta a ods
            ->getQuery()
            ->getArrayResult();
    }
    
    

}
