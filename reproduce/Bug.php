<?php

use Psalm\Aliases;
use Psalm\Codebase;
use Psalm\Internal\Analyzer\StatementsAnalyzer;
use Psalm\Internal\Scanner\FileScanner;
use Psalm\Internal\Type\TypeAlias;
use Psalm\StatementsSource;
use Psalm\Storage\ClassLikeStorage;
use Psalm\Storage\FileStorage;
use Psalm\Storage\FunctionLikeStorage;
use Psalm\Type\Union;

class Bug
{
    public function bug_1()
    {
        # Looks like LSP doesn't index composer
        # Use of unknown class: 'Composer\Autoload\ClassLoader'
    }

    public function bug_2(
        StatementsSource $statementsSource,
        StatementsAnalyzer $statements_analyzer
    ) {
        $statementsSource->getFunctionLikeStorage($statements_analyzer); # Call to unknown method: Psalm\StatementsSource::getFunctionLikeStorage()
    }

    public function bug_3()
    {
        # LSP may not understand this syntax. May support or don't parser it.
        # https://psalm.dev/r/9cdc00c1c2

        /** @var \stdClass */
        $arr = [];

        /** @var int $arr->test */
        $arr->test = 'test';

        /** @psalm-trace $arr->test */
        $arr;

        /** @var array{object} */
        $arr2 = [];
        $i = 0;

        /** @var int $arr2[$i]->test */
        $arr2[$i]->type = '';

        /** @psalm-trace $arr2[$i]->test */
        $arr2;
    }

    /**
     * @param array<string, array<string, Union>> $class_template_types
     * @param array<string, non-empty-array<string, Union>> $function_template_types
     * @param array<string, TypeAlias> $type_aliases
     * @param array<
     *     int,
     *     array{
     *         type:string,
     *         name:string,
     *         line_number:int,
     *         start:int,
     *         end:int,
     *         description?:string
     *     }
     * > $docblock_params
     */
    private static function improveParamsFromDocblock(
        Codebase $codebase,
        FileScanner $file_scanner,
        FileStorage $file_storage,
        Aliases $aliases,
        array $type_aliases,
        ?ClassLikeStorage $classlike_storage,
        FunctionLikeStorage $storage,
        array &$function_template_types,
        array $class_template_types,
        array $docblock_params,
        PhpParser\Node\FunctionLike $function,
        bool $fake_method,
        ?string $fq_classlike_name
    ): void {
        # $aliases is Aliases type, but hover returns incorrect type.
    }
}
