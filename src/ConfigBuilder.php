<?php
/**
 * Created for plugin-pbx-example
 * Date: 22.07.2021
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Instance\Pbx;

use Leadvertex\Plugin\Components\Settings\Settings;
use Leadvertex\Plugin\Core\PBX\Components\Config\Config;

class ConfigBuilder implements \Leadvertex\Plugin\Core\PBX\Components\Config\ConfigBuilder
{

    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(): Config
    {
        $config = new Config();
        $config->username = $this->settings->getData()->get('main.login');
        $config->password = $this->settings->getData()->get('main.password');
        $config->from = $this->settings->getData()->get('main.from');
        $config->protocol = $this->settings->getData()->get('advanced.protocol.0');
        $config->domain = $this->settings->getData()->get('advanced.domain');
        $config->realm = $this->settings->getData()->get('advanced.realm');
        $config->proxy = $this->settings->getData()->get('advanced.proxy');
        $config->expires = $this->settings->getData()->get('advanced.expires');
        $config->register = $this->settings->getData()->get('advanced.register');
        $config->number_format_with_plus = $this->settings->getData()->get('advanced.number_format_with_plus');
        $config->send_additional_data_via_x_headers = $this->settings->getData()->get('advanced.send_additional_data_via_x_headers');
        $config->header_for_DID = $this->settings->getData()->get('advanced.header_for_DID');
        return $config;
    }
}