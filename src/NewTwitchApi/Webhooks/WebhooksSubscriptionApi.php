<?php

declare(strict_types=1);

namespace NewTwitchApi\Webhooks;

use GuzzleHttp\Client;
use NewTwitchApi\HelixGuzzleClient;

class WebhooksSubscriptionApi
{
    public const SUBSCRIBE = 'subscribe';
    public const UNSUBSCRIBE = 'unsubscribe';

    private $clientId;
    private $secret;
    private $guzzleClient;

    public function __construct(string $clientId, string $secret, Client $guzzleClient = null)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->guzzleClient = $guzzleClient ?? new HelixGuzzleClient($clientId);
    }

    public function subscribeToStream(string $twitchId, string $bearer, string $callback, int $leaseSeconds = 0, string $mode = self::SUBSCRIBE): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/streams?user_id=%s', $twitchId),
            $bearer,
            $callback,
            $leaseSeconds,
            $mode
        );
    }

    public function subscribeToUser(string $twitchId, string $bearer, string $callback, int $leaseSeconds = 0, string $mode = self::SUBSCRIBE): void
    {
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users?id=%s', $twitchId),
            $bearer,
            $callback,
            $leaseSeconds,
            $mode
        );
    }

    public function subscribeToUserFollows(string $followerId, string $followedUserId, int $first, string $bearer, string $callback, int $leaseSeconds = 0, string $mode = self::SUBSCRIBE): void
    {
        $queryParams = [];
        if ($followerId) {
            $queryParams['from_id'] = $followerId;
        }
        if ($followedUserId) {
            $queryParams['to_id'] = $followedUserId;
        }
        if ($first) {
            $queryParams['first'] = $first;
        }
        $this->subscribe(
            sprintf('https://api.twitch.tv/helix/users/follows?%s', http_build_query($queryParams)),
            $bearer,
            $callback,
            $leaseSeconds,
            $mode
        );
    }

    public function validateWebhookEventCallback(string $xHubSignature, string $content): bool
    {
        [$hashAlgorithm, $expectedHash] = explode('=', $xHubSignature);
        $generatedHash = hash_hmac($hashAlgorithm, $content, $this->secret);

        return $expectedHash === $generatedHash;
    }

    private function subscribe(string $topic, string $bearer, string $callback, int $leaseSeconds = 0, string $mode = self::SUBSCRIBE): void
    {
        $headers = [
            'Authorization' => sprintf('Bearer %s', $bearer),
            'Client-ID' => $this->clientId,
        ];

        $body = [
            'hub.callback' => $callback,
            'hub.mode' => $mode,
            'hub.topic' => $topic,
            'hub.lease_seconds' => $leaseSeconds,
            'hub.secret' => $this->secret,
        ];

        $this->guzzleClient->post('webhooks/hub', [
            'headers' => $headers,
            'body' => json_encode($body),
        ]);
    }
}
