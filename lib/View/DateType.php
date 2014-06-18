<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Citfact\Form\View;

class DateType implements ViewInterface
{
    /**
     * @inheritdoc
     */
    public function detectet($field, $typeBuilder)
    {
        if ($typeBuilder == 'userfields') {
            if ($field['USER_TYPE_ID'] == 'datetime') {
                return true;
            }
        } elseif ($typeBuilder == 'iblock') {
            if ($field['PROPERTY_TYPE'] == 'S' && $field['USER_TYPE'] == 'DateTime') {
                return true;
            }
        }

        return false;
    }
}