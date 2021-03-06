<?php
/**
 * Shopware 4.0
 * Copyright © 2012 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Shopware_Models
 * @subpackage Shop
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author     $Author$
 */

namespace Shopware\Models\Property;
use Shopware\Components\Model\ModelRepository;

/**
 * todo@all: Documentation
 */
class Repository extends ModelRepository
{
    /**
     * Returns an instance of the \Doctrine\ORM\Query object which selects all property groups
     * with their options and attributes.
     * @return \Doctrine\ORM\Query
     */
    public function getGroupsQuery()
    {
        $builder = $this->getGroupsQueryBuilder();
        return $builder->getQuery();
    }

    /**
     * Helper function to create the query builder for the "getGroupsQuery" function.
     * This function can be hooked to modify the query builder of the query object.
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getGroupsQueryBuilder()
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select(array('groups', 'relations', 'option', 'attribute'))
                ->from('Shopware\Models\Property\Group', 'groups')
                ->leftJoin('groups.relations', 'relations')
                ->leftJoin('relations.option', 'option')
                ->leftJoin('groups.attribute', 'attribute')
                ->orderBy('groups.position')
                ->orderBy('relations.position');

        return $builder;
    }

    /**
     * Returns an instance of the \Doctrine\ORM\Query object which search the
     * property attributes for the passed group id.
     * @param $groupId
     * @return \Doctrine\ORM\Query
     */
    public function getAttributesQuery($groupId)
    {
        $builder = $this->getAttributesQueryBuilder($groupId);
        return $builder->getQuery();
    }

    /**
     * Helper function to create the query builder for the "getAttributesQuery" function.
     * This function can be hooked to modify the query builder of the query object.
     * @param $groupId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAttributesQueryBuilder($groupId)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select(array('attribute'))
                      ->from('Shopware\Models\Attribute\PropertyGroup', 'attribute')
                      ->where('attribute.propertyGroupId = ?1')
                      ->setParameter(1, $groupId);
        return $builder;
    }

    /**
     * Returns an instance of the \Doctrine\ORM\Query object which select
     * all data about the passed group id.
     * @param $groupId
     * @return \Doctrine\ORM\Query
     */
    public function getGroupDetailQuery($groupId)
    {
        $builder = $this->getGroupDetailQueryBuilder($groupId);
        return $builder->getQuery();
    }

    /**
     * Helper function to create the query builder for the "getGroupDetailQuery" function.
     * This function can be hooked to modify the query builder of the query object.
     * @param $groupId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getGroupDetailQueryBuilder($groupId)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select(array('groups', 'attribute'))
                ->from('Shopware\Models\Property\Group', 'groups')
                ->leftJoin('groups.attribute', 'attribute')
                ->where('groups.id = ?1')
                ->setParameter(1, $groupId);
        return $builder;
    }

    /**
     * Returns an instance of the \Doctrine\ORM\Query object which .....
     * @param $optionId
     * @return \Doctrine\ORM\Query
     */
    public function getPropertyValueByOptionIdQuery($optionId)
    {
        $builder = $this->getPropertyValueByOptionIdQueryBuilder($optionId);
        return $builder->getQuery();
    }

    /**
     * Helper function to create the query builder for the "getPropertyValueByOptionIdQuery" function.
     * This function can be hooked to modify the query builder of the query object.
     * @param $optionId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getPropertyValueByOptionIdQueryBuilder($optionId)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select(array('value'))
                ->from('Shopware\Models\Property\Value', 'value')
                ->where('value.optionId = ?0')
                ->setParameter(0, $optionId);

        return $builder;
    }

}
