<?php

namespace App\Generators\Views;

use App\Generators\GeneratorUtils;

class GenerateActionView
{
    /**
     * Generate a action(table) view
     * @param array $request
     * @return void
     */
    public function execute(array $request)
    {
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($request['model']);
        $modelNameSingularLowercase = GeneratorUtils::cleanSingularLowerCase($request['model']);

        $template = str_replace(
            [
                '{{modelNameSingularLowercase}}',
                '{{modelNamePluralKebabCase}}'
            ],
            [
                $modelNameSingularLowercase,
                $modelNamePluralKebabCase
            ],
            GeneratorUtils::getTemplate('views/action')
        );

        GeneratorUtils::checkFolder(resource_path("/views/$modelNamePluralKebabCase/include"));

        GeneratorUtils::generateTemplate(resource_path("/views/$modelNamePluralKebabCase/include/action.blade.php"), $template);
    }
}
