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
 * @param string|array $function The function
 * @param array $param_arr The parameters
 * @return mixed The call result
 */
function call_user_func_assoc($function, $param_arr)
{
    // Initialize the reflection
    $reflection = null;
    if (is_array($function)) {
        list($class, $name) = $function;
        $reflection = new ReflectionMethod($class, $name);
    } elseif (is_string($function)) {
        $reflection = new ReflectionFunction($function);
    }

    // Check if reflection is initialized
    if (is_null($reflection)) {
        throw new \LogicException(sprintf('$function must be an instance of string or array, %s given.', gettype($function)));
    }

    // Rebuild the parameters array
    if (array_values($param_arr) !== $param_arr) {
        $newParameters = [];
        foreach ($reflection->getParameters() as $parameter) {
            $value = null;
            // Check if the value is passed
            if (isset($param_arr[$parameter->getName()])) {
                $value = $param_arr[$parameter->getName()];
            }
            // Otherwise, check if the parameter is optional and pass the default value
            elseif ($parameter->isOptional()) {
                $value = $parameter->getDefaultValue();
            }
            // Append it to the newParameters Array
            $newParameters[] = $value;
        }
        // Override the parameters array
        $param_arr = $newParameters;
    }

    // Call the function
    return call_user_func_array($function, $param_arr);
}