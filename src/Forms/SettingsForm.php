<?php
/**
 * Created for plugin-exporter-excel
 * Datetime: 03.03.2020 15:43
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace SalesRender\Plugin\Instance\Pbx\Forms;


use SalesRender\Plugin\Components\Form\FieldDefinitions\BooleanDefinition;
use SalesRender\Plugin\Components\Form\FieldDefinitions\FieldDefinition;
use SalesRender\Plugin\Components\Form\FieldDefinitions\IntegerDefinition;
use SalesRender\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Limit;
use SalesRender\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values\StaticValues;
use SalesRender\Plugin\Components\Form\FieldDefinitions\ListOfEnumDefinition;
use SalesRender\Plugin\Components\Form\FieldDefinitions\PasswordDefinition;
use SalesRender\Plugin\Components\Form\FieldDefinitions\StringDefinition;
use SalesRender\Plugin\Components\Form\FieldGroup;
use SalesRender\Plugin\Components\Form\Form;
use SalesRender\Plugin\Components\Form\FormData;
use SalesRender\Plugin\Components\Translations\Translator;

class SettingsForm extends Form
{

    public function __construct()
    {
        $nonNull = function ($value, FieldDefinition $definition, FormData $data) {
            $errors = [];
            if (is_null($value)) {
                $errors[] = Translator::get('settings', 'Поле не может быть пустым');
            }
            return $errors;
        };
        parent::__construct(
            Translator::get('settings', 'Настройки телефонии'),
            Translator::get('settings', 'Все внесенные изменения вступят в силу в течение 30 сек'),
            [
                'main' => new FieldGroup(
                    Translator::get('settings', 'Основные настройки'),
                    null,
                    [
                        'login' => new StringDefinition(
                            Translator::get('settings', 'Логин'),
                            null,
                            $nonNull
                        ),
                        'password' => new PasswordDefinition(
                            Translator::get('settings', 'Пароль'),
                            null,
                            $nonNull
                        ),
                        'from' => new StringDefinition(
                            Translator::get('settings', 'Исходящий номер'),
                            null,
                            function () {
                                return [];
                            },
                            ''
                        ),
                    ]
                ),
                'advanced' => new FieldGroup(
                    Translator::get('settings', 'Продвинутые настройки'),
                    null,
                    [
                        'protocol' => new ListOfEnumDefinition(
                            Translator::get('settings', 'Протокол'),
                            null,
                            $nonNull,
                            new StaticValues([
                                'tcp' => [
                                    'title' => 'TCP',
                                    'group' => Translator::get('settings', 'Протокол'),
                                ],
                                'udp' => [
                                    'title' => 'UDP',
                                    'group' => Translator::get('settings', 'Протокол'),
                                ],
                            ]),
                            new Limit(1, 1),
                            ['udp']
                        ),
                        'domain' => new StringDefinition(
                            Translator::get('settings', 'Домен'),
                            null,
                            $nonNull
                        ),
                        'realm' => new StringDefinition(
                            'Realm',
                            null,
                            $nonNull
                        ),
                        'proxy' => new StringDefinition(
                            Translator::get('settings', 'Прокси'),
                            null,
                            $nonNull
                        ),
                        'expires' => new IntegerDefinition(
                            Translator::get('settings', 'Время жизни'),
                            null,
                            $nonNull,
                            600
                        ),
                        'register' => new BooleanDefinition(
                            Translator::get('settings', 'Требует регистрации'),
                            null,
                            $nonNull,
                            false
                        ),
                        'number_format_with_plus' => new BooleanDefinition(
                            Translator::get('settings', 'Передавать номер с плюсом'),
                            null,
                            $nonNull,
                            true
                        ),
                        'send_additional_data_via_x_headers' => new BooleanDefinition(
                            Translator::get('settings', 'Передавать дополнительную информацию в заголовках'),
                            null,
                            $nonNull,
                            true
                        ),
                    ]
                ),
            ],
            Translator::get('settings', 'Сохранить'),
        );
    }
}


