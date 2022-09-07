<?php
/**
 * Created for plugin-pbx-example
 * Date: 22.07.2021
 * @author Timur Kasumov (XAKEPEHOK)
 */

namespace Leadvertex\Plugin\Instance\Pbx\Parsers;


use Exception;
use Leadvertex\Plugin\Components\Access\Registration\Registration;
use Leadvertex\Plugin\Components\Access\Token\GraphqlInputToken;
use Leadvertex\Plugin\Components\Db\Components\Connector;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CDR;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CdrPricing;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CdrSender;
use Leadvertex\Plugin\Core\PBX\Components\CDR\CdrWebhookParserInterface;
use Money\Currency;
use Money\Money;
use Slim\Exception\HttpException;
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
        return '/protected/cdr-webhook';
    }

    /**
     * @param ServerRequest $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(ServerRequest $request, Response $response, array $args): Response
    {
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

        $jwt = $request->getHeader('X-PLUGIN-TOKEN')[0] ?? '';

        if (empty($jwt)) {
            throw new HttpException($request, 'X-PLUGIN-TOKEN not found', 401);
        }

        try {
            $token = new GraphqlInputToken($jwt);
        } catch (Exception $exception) {
            throw new HttpException($request, $exception->getMessage(), 403);
        }

        Connector::setReference($token->getPluginReference());
        if (Registration::find() === null) {
            throw new HttpException($request, 'Plugin was not registered', 403);
        }

        $cdrSender = new CdrSender(...$result);
        $cdrSender();
        return $response->withJson($result);
    }
}