<?php

namespace App\Generators\Views;

use App\Generators\GeneratorUtils;

class FormViewGenerator
{
    /**
     * Generate a form/input for create and edit.
     *
     * @param array $request
     * @return void
     */
    public function generate(array $request)
    {
        $model = GeneratorUtils::setModelName($request['model']);
        $path = GeneratorUtils::getModelLocation($request['model']);

        $modelNameSingularCamelCase = GeneratorUtils::singularCamelCase($model);
        $modelNamePluralKebabCase = GeneratorUtils::pluralKebabCase($model);

        $template = "<div class=\"row mb-2\">\n";

        foreach ($request['fields'] as $i => $field) {

            if ($request['input_types'][$i] !== 'no-input') {
                $fieldSnakeCase = str()->snake($field);
                $fieldUcWords = GeneratorUtils::cleanUcWords($field);

                if ($request['column_types'][$i] == 'enum') {
                    $options = "";

                    $arrOption = explode('|', $request['select_options'][$i]);

                    $totalOptions = count($arrOption);

                    switch ($request['input_types'][$i]) {
                        case 'select':
                            // select
                            foreach ($arrOption as $arrOptionIndex => $value) {
                                $options .= "<option value=\"" . $value . "\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '" . $value . "' ? 'selected' : (old('$fieldSnakeCase') == '" . $value . "' ? 'selected' : '') }}>$value</option>";

                                if ($arrOptionIndex + 1 != $totalOptions) {
                                    $options .= "\n\t\t";
                                } else {
                                    $options .= "\t\t\t";
                                }
                            }

                            $template .= str_replace(
                                [
                                    '{{fieldLowercase}}',
                                    '{{fieldUppercase}}',
                                    '{{fieldSpaceLowercase}}',
                                    '{{fieldSnakeCase}}',
                                    '{{options}}',
                                    '{{nullable}}'
                                ],
                                [
                                    $fieldSnakeCase,
                                    $fieldUcWords,
                                    GeneratorUtils::cleanSingularLowerCase($field),
                                    $fieldSnakeCase,
                                    $options,
                                    $request['requireds'][$i] == 'yes' ? ' required' : '',
                                ],
                                GeneratorUtils::getTemplate('views/forms/select')
                            );
                            break;
                        case 'datalist':
                            foreach ($arrOption as $arrOptionIndex => $value) {
                                $options .= "<option value=\"" . $value . "\">$value</option>";

                                if ($arrOptionIndex + 1 != $totalOptions) {
                                    $options .= "\n\t\t";
                                } else {
                                    $options .= "\t\t\t";
                                }
                            }

                            $template .= str_replace(
                                [
                                    '{{fieldKebabCase}}',
                                    '{{fieldCamelCase}}',
                                    '{{fieldUcWords}}',
                                    '{{fieldSnakeCase}}',
                                    '{{options}}',
                                    '{{nullable}}',
                                    '{{value}}',
                                ],
                                [
                                    GeneratorUtils::singularKebabCase($field),
                                    GeneratorUtils::singularCamelCase($field),
                                    $fieldUcWords,
                                    $fieldSnakeCase,
                                    $options,
                                    $request['requireds'][$i] == 'yes' ? ' required' : '',
                                    "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}"
                                ],
                                GeneratorUtils::getTemplate('views/forms/datalist')
                            );
                            break;
                        default:
                            // radio
                            $options .= "\t<div class=\"col-md-6\">\n\t<p>$fieldUcWords</p>\n";

                            foreach ($arrOption as $value) {
                                $options .= str_replace(
                                    [
                                        '{{fieldSnakeCase}}',
                                        '{{optionKebabCase}}',
                                        '{{value}}',
                                        '{{optionLowerCase}}',
                                        '{{checked}}',
                                        '{{nullable}}'
                                    ],
                                    [
                                        $fieldSnakeCase,
                                        GeneratorUtils::singularKebabCase($value),
                                        $value,
                                        GeneratorUtils::cleanSingularLowerCase($value),
                                        "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$field == '$value' ? 'checked' : (old('$field') == '$value' ? 'checked' : '') }}",
                                        $request['requireds'][$i] == 'yes' ? ' required' : '',
                                    ],
                                    GeneratorUtils::getTemplate('views/forms/radio')
                                );
                            }

                            $options .= "\t</div>\n";

                            $template .= $options;
                            break;
                    }
                } else if ($request['column_types'][$i] == 'foreignId') {
                    // remove '/' or sub folders
                    $constrainModel = GeneratorUtils::setModelName($request['constrains'][$i]);

                    $constrainSingularCamelCase = GeneratorUtils::singularCamelCase($constrainModel);

                    $columnAfterId = GeneratorUtils::getColumnAfterId($constrainModel);

                    $options = "
                    @foreach ($" .  GeneratorUtils::pluralCamelCase($constrainModel) . " as $$constrainSingularCamelCase)
                        <option value=\"{{ $" . $constrainSingularCamelCase . "->id }}\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == $" . $constrainSingularCamelCase . "->id ? 'selected' : (old('$fieldSnakeCase') == $" . $constrainSingularCamelCase . "->id ? 'selected' : '') }}>
                            {{ $" . $constrainSingularCamelCase . "->$columnAfterId }}
                        </option>
                    @endforeach";

                    switch ($request['input_types'][$i]) {
                        case 'datalist':
                            $template .= str_replace(
                                [
                                    '{{fieldKebabCase}}',
                                    '{{fieldSnakeCase}}',
                                    '{{fieldUcWords}}',
                                    '{{fieldCamelCase}}',
                                    '{{options}}',
                                    '{{nullable}}',
                                    '{{value}}',
                                ],
                                [
                                    GeneratorUtils::singularKebabCase($field),
                                    $fieldSnakeCase,
                                    $fieldUcWords,
                                    GeneratorUtils::singularCamelCase($field),
                                    $options,
                                    $request['requireds'][$i] == 'yes' ? ' required' : '',
                                    "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}"
                                ],
                                GeneratorUtils::getTemplate('views/forms/datalist')
                            );
                            break;
                        default:
                            // select
                            $template .= str_replace(
                                [
                                    '{{fieldLowercase}}',
                                    '{{fieldUppercase}}',
                                    '{{fieldSpaceLowercase}}',
                                    '{{options}}',
                                    '{{nullable}}'
                                ],
                                [
                                    $fieldSnakeCase,
                                    GeneratorUtils::cleanSingularUcWords($constrainModel),
                                    GeneratorUtils::cleanSingularLowerCase($constrainModel),
                                    $options,
                                    $request['requireds'][$i] == 'yes' ? ' required' : '',
                                ],
                                GeneratorUtils::getTemplate('views/forms/select')
                            );
                            break;
                    }
                } else if ($request['column_types'][$i] == 'year') {
                    $firstYear = is_int(config('generator.format.first_year')) ? config('generator.format.first_year') : 1900;

                    /**
                     * Will generate something like:
                     *
                     * <select class="form-select" name="year" id="year" class="form-control" required>
                     * <option value="" selected disabled>-- {{ __('Select year') }} --</option>
                     *  @foreach (range(1900, strftime('%Y', time())) as $year)
                     *     <option value="{{ $year }}"
                     *        {{ isset($book) && $book->year == $year ? 'selected' : (old('year') == $year ? 'selected' : '') }}>
                     *      {{ $year }}
                     * </option>
                     *  @endforeach
                     * </select>
                     */
                    $options = "
                    @foreach (range($firstYear, strftime(\"%Y\", time())) as \$year)
                        <option value=\"{{ \$year }}\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == \$year ? 'selected' : (old('$fieldSnakeCase') == \$year ? 'selected' : '') }}>
                            {{ \$year }}
                        </option>
                    @endforeach";

                    switch ($request['input_types'][$i]) {
                        case 'datalist':
                            $template .= str_replace(
                                [
                                    '{{fieldKebabCase}}',
                                    '{{fieldCamelCase}}',
                                    '{{fieldUcWords}}',
                                    '{{fieldSnakeCase}}',
                                    '{{options}}',
                                    '{{nullable}}',
                                    '{{value}}',
                                ],
                                [
                                    GeneratorUtils::singularKebabCase($field),
                                    GeneratorUtils::singularCamelCase($field),
                                    $fieldUcWords,
                                    $fieldSnakeCase,
                                    $options,
                                    $request['requireds'][$i] == 'yes' ? ' required' : '',
                                    "{{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . " : old('" . $fieldSnakeCase . "') }}"
                                ],
                                GeneratorUtils::getTemplate('views/forms/datalist')
                            );
                            break;
                        default:
                            $template .= str_replace(
                                [
                                    '{{fieldLowercase}}',
                                    '{{fieldUppercase}}',
                                    '{{fieldSpaceLowercase}}',
                                    '{{fieldSnakeCase}}',
                                    '{{options}}',
                                    '{{nullable}}'
                                ],
                                [
                                    $fieldSnakeCase,
                                    GeneratorUtils::cleanSingularUcWords($field),
                                    GeneratorUtils::cleanSingularLowerCase($field),
                                    $fieldSnakeCase,
                                    $options,
                                    $request['requireds'][$i] == 'yes' ? ' required' : '',
                                ],
                                GeneratorUtils::getTemplate('views/forms/select')
                            );
                            break;
                    }
                } else if ($request['column_types'][$i] == 'boolean') {
                    switch ($request['input_types'][$i]) {
                        case 'select':
                            // select
                            $options = "<option value=\"0\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'selected' : (old('$fieldSnakeCase') == '0' ? 'selected' : '') }}>{{ __('True') }}</option>\n\t\t\t\t<option value=\"1\" {{ isset($" . $modelNameSingularCamelCase . ") && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'selected' : (old('$fieldSnakeCase') == '1' ? 'selected' : '') }}>{{ __('False') }}</option>";

                            $template .= str_replace(
                                [
                                    '{{fieldLowercase}}',
                                    '{{fieldUppercase}}',
                                    '{{fieldSpaceLowercase}}',
                                    '{{options}}',
                                    '{{nullable}}'
                                ],
                                [
                                    $fieldSnakeCase,
                                    $fieldUcWords,
                                    GeneratorUtils::cleanSingularLowerCase($field),
                                    $options,
                                    $request['requireds'][$i] == 'yes' ? ' required' : '',
                                ],
                                GeneratorUtils::getTemplate('views/forms/select')
                            );
                            break;

                        default:
                            // radio
                            $options = "\t<div class=\"col-md-6\">\n\t<p>$fieldUcWords</p>";

                            /**
                             * will generate something like:
                             *
                             * <div class="form-check mb-2">
                             *  <input class="form-check-input" type="radio" name="is_active" id="is_active-1" value="1" {{ isset($product) && $product->is_active == '1' ? 'checked' : (old('is_active') == '1' ? 'checked' : '') }}>
                             *     <label class="form-check-label" for="is_active-1">True</label>
                             * </div>
                             *  <div class="form-check mb-2">
                             *    <input class="form-check-input" type="radio" name="is_active" id="is_active-0" value="0" {{ isset($product) && $product->is_active == '0' ? 'checked' : (old('is_active') == '0' ? 'checked' : '') }}>
                             *      <label class="form-check-label" for="is_active-0">False</label>
                             * </div>
                             */
                            $options .= "
                            <div class=\"form-check mb-2\">
                                <input class=\"form-check-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-1\" value=\"1\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '1' ? 'checked' : (old('$fieldSnakeCase') == '1' ? 'checked' : '') }}>
                                <label class=\"form-check-label\" for=\"$fieldSnakeCase-1\">True</label>
                            </div>
                            <div class=\"form-check mb-2\">
                                <input class=\"form-check-input\" type=\"radio\" name=\"$fieldSnakeCase\" id=\"$fieldSnakeCase-0\" value=\"0\" {{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase == '0' ? 'checked' : (old('$fieldSnakeCase') == '0' ? 'checked' : '') }}>
                                <label class=\"form-check-label\" for=\"$fieldSnakeCase-0\">False</label>
                            </div>\n";

                            $options .= "\t</div>\n";

                            $template .= $options;
                            break;
                    }
                } else if ($request['input_types'][$i] == 'textarea') {

                    // textarea
                    $template .= str_replace(
                        [
                            '{{fieldLowercase}}',
                            '{{fieldUppercase}}',
                            '{{modelName}}',
                            '{{nullable}}'
                        ],
                        [
                            $fieldSnakeCase,
                            $fieldUcWords,
                            $modelNameSingularCamelCase,
                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                        ],
                        GeneratorUtils::getTemplate('views/forms/textarea')
                    );
                } else if ($request['input_types'][$i] == 'file') {

                    $template .= str_replace(
                        [
                            '{{modelCamelCase}}',
                            '{{fieldPluralSnakeCase}}',
                            '{{fieldSnakeCase}}',
                            '{{fieldUcWords}}',
                            '{{nullable}}',
                            '{{defaultImage}}',
                            '{{uploadPathPublic}}',
                        ],
                        [
                            $modelNameSingularCamelCase,
                            GeneratorUtils::pluralSnakeCase($field),
                            str()->snake($field),
                            $fieldUcWords,
                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                            config('generator.image.default') ?? 'https://via.placeholder.com/350?text=No+Image+Avaiable',
                            config('generator.image.path') == 'storage' ? "storage/uploads" : "uploads",
                        ],
                        GeneratorUtils::getTemplate('views/forms/image')
                    );
                } else if ($request['input_types'][$i] == 'range') {
                    $template .= str_replace(
                        [
                            '{{fieldSnakeCase}}',
                            '{{fieldUcWords}}',
                            '{{fieldKebabCase}}',
                            '{{nullable}}',
                            '{{min}}',
                            '{{max}}',
                            '{{step}}'
                        ],
                        [
                            GeneratorUtils::singularSnakeCase($field),
                            $fieldUcWords,
                            GeneratorUtils::singularKebabCase($field),
                            $request['requireds'][$i] == 'yes' ? ' required' : '',
                            $request['min_lengths'][$i],
                            $request['max_lengths'][$i],
                            $request['steps'][$i] ? 'step="' . $request['steps'][$i] . '"' : '',
                        ],
                        GeneratorUtils::getTemplate('views/forms/range')
                    );
                } else {
                    // input form
                    $formatValue = "{{ isset($$modelNameSingularCamelCase) ? $$modelNameSingularCamelCase->$fieldSnakeCase : old('$fieldSnakeCase') }}";

                    switch ($request['input_types'][$i]) {
                        case 'datetime-local':
                            /**
                             * Will generate something like:
                             *
                             * {{ isset($book) && $book->datetime ? $book->datetime->format('Y-m-d\TH:i') : old('datetime') }}
                             */
                            $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m-d\TH:i') : old('$fieldSnakeCase') }}";
                            break;
                        case 'date':
                            /**
                             * Will generate something like:
                             *
                             * {{ isset($book) && $book->date ? $book->date->format('Y-m-d') : old('date') }}
                             */
                            $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m-d') : old('$fieldSnakeCase') }}";
                            break;
                        case 'time':
                            /**
                             * Will generate something like:
                             *
                             * {{ isset($book) ? $book->time->format('H:i') : old('time') }}
                             */
                            $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('H:i') : old('$fieldSnakeCase') }}";
                            break;
                        case 'week':
                            /**
                             * Will generate something like:
                             *
                             * {{ isset($book) ? $book->week->format('Y-\WW') : old('week') }}
                             */
                            $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-\WW') : old('$fieldSnakeCase') }}";
                            break;
                        case 'month':
                            /**
                             * Will generate something like:
                             *
                             * {{ isset($book) ? $book->month->format('Y-\WW') : old('month') }}
                             */
                            $formatValue = "{{ isset($$modelNameSingularCamelCase) && $" . $modelNameSingularCamelCase . "->$fieldSnakeCase ? $" . $modelNameSingularCamelCase . "->" . $fieldSnakeCase . "->format('Y-m') : old('$fieldSnakeCase') }}";
                            break;
                        case 'password':
                            $formatValue = "";
                            break;
                        default:
                            break;
                    }

                    switch ($request['input_types'][$i]) {
                        case 'hidden':
                            $template .= '<input type="hidden" name="' . $fieldSnakeCase . '" value="' . $request['default_values'][$i] . '">';
                            break;
                        default:
                            $template .= str_replace(
                                [
                                    '{{fieldKebabCase}}',
                                    '{{fieldUcWords}}',
                                    '{{fieldSnakeCase}}',
                                    '{{fieldCamelCase}}',
                                    '{{modelName}}',
                                    '{{type}}',
                                    '{{value}}',
                                    '{{nullable}}',
                                ],
                                [
                                    GeneratorUtils::singularKebabCase($field),
                                    $fieldUcWords,
                                    $fieldSnakeCase,
                                    GeneratorUtils::singularCamelCase($field),
                                    $modelNameSingularCamelCase,
                                    $request['input_types'][$i],
                                    $formatValue,
                                    $this->setRequiredOfInput(
                                        required: $request['requireds'][$i],
                                        input: $request['input_types'][$i],
                                        model: $modelNameSingularCamelCase
                                    ),
                                ],
                                GeneratorUtils::getTemplate('views/forms/input')
                            );
                            break;
                    }
                }
            }
        }

        $template .= "</div>";

        // create a blade file
        switch ($path) {
            case '':
                GeneratorUtils::checkFolder(resource_path("/views/$modelNamePluralKebabCase/include"));
                file_put_contents(resource_path("/views/$modelNamePluralKebabCase/include/form.blade.php"), $template);
                break;
            default:
                $fullPath = resource_path("/views/" . strtolower($path) . "/$modelNamePluralKebabCase/include");
                GeneratorUtils::checkFolder($fullPath);
                file_put_contents($fullPath . "/form.blade.php", $template);
                break;
        }
    }

    /**
     *  Set required of input, when input type password will generate a special code.
     *
     * @param string $required
     * @param string $input
     * @param string $model
     * @return string
     */
    public function setRequiredOfInput(string $required, string $input, string $model): string
    {
        if ($required == 'yes' && $input == 'password') {
            /**
             * will generate something like:
             *
             * {{ empty($user) ? 'required' : '' }}
             */
            return "{{ empty(\$". $model .") ? ' required' : '' }}";
        }

        if ($required == 'yes') {
            return ' required';
        }

        return '';
    }
}
