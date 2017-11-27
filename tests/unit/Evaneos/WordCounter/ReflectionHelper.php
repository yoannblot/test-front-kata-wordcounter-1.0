<?php
declare(strict_types=1);

namespace Evaneos\WordCounter;

/**
 * Class ReflectionHelper.
 *
 * @package Evaneos\WordCounter
 */
abstract class ReflectionHelper {

    /**
     * Get property value of given object.
     *
     * @param \object $oObject object to get value.
     * @param string $sPropertyName property name.
     *
     * @return mixed property value.
     */
    public static function getProperty ($oObject, string $sPropertyName) {
        $oReflection = new \ReflectionClass($oObject);
        $oProperty = $oReflection->getProperty($sPropertyName);
        $oProperty->setAccessible(true);

        return $oProperty->getValue($oObject);
    }
}