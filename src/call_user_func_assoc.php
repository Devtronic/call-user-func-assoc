<?php
/*
 * This file is part of the devtronic/call-user-func-assoc package.
 *
 * (c) Julian Finkler <julian@developer-heaven.de>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Call User Func Assoc
 * Calls a function with an associative array
 *
 * @param string|array|object $function The function
 * @param array $paramArray The parameters
 * @return mixed The call result
 */
function call_user_func_assoc($function, $paramArray)
{
    // Initialize the reflection
    $reflection = null;
    if (is_array($function)) {
        list($class, $name) = $function;
        $reflection = new ReflectionMethod($class, $name);
    } else if (is_string($function)) {
        $reflection = new ReflectionFunction($function);
    } else if (is_callable($function)) {
        $reflection = new ReflectionFunction($function);
    }

    // Check if reflection is initialized
    if (is_null($reflection)) {
        throw new \LogicException(sprintf('$function must be an instance of string, array or callable, %s given.', gettype($function)));
    }

    // Rebuild the parameters array
    if (array_values($paramArray) !== $paramArray) {
        $newParameters = [];
        foreach ($reflection->getParameters() as $parameter) {
            $value = null;
            // Check if the value is passed
            if (isset($paramArray[$parameter->getName()])) {
                $value = $paramArray[$parameter->getName()];
            } // Otherwise, check if the parameter is optional and pass the default value
            elseif ($parameter->isOptional()) {
                $value = $parameter->getDefaultValue();
            }
            // Append it to the newParameters Array
            $newParameters[] = $value;
        }
        // Override the parameters array
        $paramArray = $newParameters;
    }

    // Call the function
    return call_user_func_array($function, $paramArray);
}