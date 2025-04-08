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

    public function findTiposIniciativa(): array
    {
        return $this->createQueryBuilder('i')
            ->select('DISTINCT i.tipo') // Asegura que no haya duplicados
            ->orderBy('i.tipo', 'DESC')
            ->getQuery()
            ->getSingleColumnResult();  
    }
    public function countIniciativasPorTipo(): array
    {
        return $this->createQueryBuilder('i')
            ->select('i.tipo, COUNT(i.id) AS total')
            ->groupBy('i.tipo')
            ->orderBy('i.tipo', 'DESC')
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
                      m.nombre AS nombre_modulo')  // Aquí seleccionamos el nombre del módulo
            ->join('i.modulos', 'im')  // IniciativaModulo
            ->join('im.modulo', 'm')
            ->join('m.moduloClases', 'mc')  // Relación con la tabla intermedia ModuloClase
            ->join('mc.clase', 'cl')  // Relación con la entidad Clase
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
            ->addSelect('m', 'o')  // Para traer los datos de metas y ODS en la misma consulta
            ->getQuery()
            ->getResult();
    }

    public function findAllWithIniciativaMetaOds()
    {
        return $this->createQueryBuilder('i')
            ->leftJoin('i.metasIniciativas', 'im')
            ->leftJoin('im.idMetas', 'm')
            ->leftJoin('m.ods', 'o')
            ->addSelect('im')
            ->addSelect('m')
            ->addSelect('o')
            ->getQuery()
            ->getResult();
    }

    



    //    /**
    //     * @return Iniciativa[] Returns an array of Iniciativa objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Iniciativa
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
