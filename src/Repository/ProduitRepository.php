<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // Recherche des produits par catégorie
    public function findByCategorie(string $categorie): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categorie = :categorie')
            ->setParameter('categorie', $categorie)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Recherche des produits avec un prix supérieur à une certaine valeur
    public function findByPrixSuperieur(float $prix): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.prix > :prix')
            ->setParameter('prix', $prix)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Recherche des produits par nom
    public function findByNom(string $nom): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nom LIKE :nom')
            ->setParameter('nom', '%' . $nom . '%')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
