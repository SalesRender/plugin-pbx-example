<?php
/**
 * Created for plugin-pbx-example
 * Date: 22.07.2021
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Instance\Pbx\Parsers;

use Leadvertex\Plugin\Core\PBX\Components\CDR\CDR;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CdrPricing;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CdrWebhookParserInterface;
use Money\Currency;
use Money\Money;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class CdrWebhookParser implements CdrWebhookParserInterface
{

    public function httpMethod(): string
    {
        return 'POST';
    }

    public function getPattern(): string
    {
        return 'protected/cdr-webhook';
    }

    /**
     * @param ServerRequest $request
     * @param Response $response
     * @param array $args
     * @return CDR[]
     */
    public function __invoke(ServerRequest $request, Response $response, array $args): array
    {
        $cdrCount = rand(1, 10);
        $result = [];
        foreach ($request->getParsedBody() as $uuid => $data) {
            $cdr = new CDR($data['phone']);
            $cdr->callId = $uuid;
            $cdr->timestamp = $data['timestamp'];
            $cdr->duration = $data['duration'];
            $cdr->recordUri = "https://storage.example.com/{$uuid}.mp3";
            $cdr->pricing = new CdrPricing(new Money(
                $data['cost'],
                new Currency($_ENV['LV_PLUGIN_PBX_PRICING_CURRENCY'])
            ));
            $result[] = $cdr;
        }
        return $result;
    }
}