<?php
/**
 * Created for plugin-exporter-excel
 * Datetime: 03.03.2020 15:43
 * @author Timur Kasumov aka XAKEPEHOK
 */

namespace Leadvertex\Plugin\Instance\Pbx\Forms;


use Leadvertex\Plugin\Components\Form\FieldDefinitions\BooleanDefinition;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\IntegerDefinition;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Limit;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnum\Values\StaticValues;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\ListOfEnumDefinition;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\PasswordDefinition;
use Leadvertex\Plugin\Components\Form\FieldDefinitions\StringDefinition;
use Leadvertex\Plugin\Components\Form\FieldGroup;
use Leadvertex\Plugin\Components\Form\Form;
use Leadvertex\Plugin\Components\Translations\Translator;

class SettingsForm extends Form
{

    public function __construct()
    {
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
                            fn() => []
                        ),
                        'password' => new PasswordDefinition(
                            Translator::get('settings', 'Пароль'),
                            null,
                            fn() => []
                        ),
                        'from' => new StringDefinition(
                            Translator::get('settings', 'Исходящий номер'),
                            null,
                            fn() => []
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
                            fn() => [],
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
                            'udp'
                        ),
                        'domain' => new StringDefinition(
                            Translator::get('settings', 'Домен'),
                            null,
                            fn() => []
                        ),
                        'realm' => new StringDefinition(
                            'Realm',
                            null,
                            fn() => []
                        ),
                        'proxy' => new StringDefinition(
                            Translator::get('settings', 'Прокси'),
                            null,
                            fn() => []
                        ),
                        'expires' => new IntegerDefinition(
                            Translator::get('settings', 'Время жизни'),
                            null,
                            fn() => [],
                            600
                        ),
                        'register' => new BooleanDefinition(
                            Translator::get('settings', 'Требует регистрации'),
                            null,
                            fn() => [],
                            false
                        ),
                        'number_format_with_plus' => new BooleanDefinition(
                            Translator::get('settings', 'Передавать номер с плюсом'),
                            null,
                            fn() => [],
                            true
                        ),
                        'send_additional_data_via_x_headers' => new BooleanDefinition(
                            Translator::get('settings', 'Передавать дополнительную информацию в заголовках'),
                            null,
                            fn() => [],
                            true
                        ),
                    ]
                ),
            ],
            Translator::get('settings', 'Сохранить'),
        );
    }
}


