<?php

use Psalm\Type\Atomic\TGenericObject;
use Psalm\Type\Atomic\TLiteralString;
use Psalm\Type\Union;

class Bug
{
    /**
     * @param TGenericObject $type
     * @return void
     */
    public function bug_1($type)
    {
        /**
         * LSP suggests this property but diagnostics returns an error
         */
        $type->extra_types; # Undefined property: TGenericObject::$extra_types
    }

    public function bug_2()
    {
        new Union([], []); # Argument '2' passed to __construct() is expected to be of type TProperties|null, array given
    }

    public function bug_3(): TLiteralString
    {
        $types = [1, 2, 3];

        return reset($types); # Using "void' as a return value from a function reset()
    }
}
