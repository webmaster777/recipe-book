<?php
/**
 * Created by PhpStorm.
 * User: meindertjan
 * Date: 29/10/2017
 * Time: 09:08
 */

namespace Mkroese\RecipeBook\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class RecipeRepository
 * @package Mkroese\RecipeBook\Entity\Repository
 *
 *
 */
class RecipeRepository extends EntityRepository
{
  public function findWithTitleLike($title)
  {
    $q = $this->getEntityManager()->createQuery(<<<DQL
SELECT rec.*
FROM Recipe rec
WHERE rec.title LIKE ?
DQL
);
    return $q->execute([sprintf('%%%s%%',$title)]);
  }

}
