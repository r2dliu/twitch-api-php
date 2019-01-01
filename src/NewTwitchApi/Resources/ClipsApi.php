<?php

declare(strict_types=1);

namespace NewTwitchApi\Resources;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ClipsApi extends AbstractResource
{
    /**
     * @throws GuzzleException
     * @link https://dev.twitch.tv/docs/api/reference/#create-clip
     */
    public function createClip(int $broadcaster_id, string $accessToken): ResponseInterface
    {
        $queryParamsMap = [
            'broadcaster_id' => $broadcaster_id,
        ];

        return $this->callApi(self::POST, 'clips', $queryParamsMap, $accessToken);
    }
}
