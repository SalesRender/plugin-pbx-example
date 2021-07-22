<?php
/**
 * Created for plugin-pbx-example
 * Date: 22.07.2021
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Instance\Pbx\Parsers;

use Leadvertex\Plugin\Components\Db\Helpers\UuidHelper;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CDR;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CdrApiParserInterface as CdrApiParserInterfaceAlias;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CdrPricing;
use Money\Currency;
use Money\Money;

class CdrApiParser implements CdrApiParserInterfaceAlias
{

    public function __invoke(): array
    {
        $cdrCount = rand(1, 10);
        $result = [];
        for ($i = 1; $i <= $cdrCount; $i++) {
            $uuid = UuidHelper::getUuid();
            $cdr = new CDR($this->generatePhone());
            $cdr->callId = $uuid;
            $cdr->timestamp = time() - rand(10, 900);
            $cdr->duration = time() - rand(3, 60 * 30);
            $cdr->recordUri = "https://storage.example.com/{$uuid}.mp3";

            $cost = round($cdr->duration / 60 * 1.2);
            $cdr->pricing = new CdrPricing(new Money(
                $cost,
                new Currency($_ENV['LV_PLUGIN_PBX_PRICING_CURRENCY'])
            ));
            $result[] = $cdr;
        }
        return $result;
    }

    private function generatePhone(): string
    {
        $phone = '+79';
        for ($i = 1; $i <= 9; $i++) {
            $phone.= rand(0,9);
        }
        return $phone;
    }
}