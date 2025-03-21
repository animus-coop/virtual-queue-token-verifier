<?php

namespace VirtualQueue\TokenVerifier;

use VirtualQueue\TokenVerifier\Exception\ApiException;
use VirtualQueue\TokenVerifier\Exception\NetworkException;
use VirtualQueue\TokenVerifier\Exception\SdkException;
use VirtualQueue\TokenVerifier\Http\HttpClient;

/**
 * Client to verify virtual queue tokens.
 */
class TokenVerifier
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Constructor.
     *
     * @param string|null $baseUrl API base URL (optional)
     * @param array $options Additional options
     */
    public function __construct(?string $baseUrl = null, array $options = [])
    {
        $this->httpClient = new HttpClient($baseUrl ?? 'https://app.virtual-queue.com', $options);
    }

    /**
     * Verifies a virtual queue token.
     *
     * @param string $token Token to verify
     * @return array Verified token data
     * @throws ApiException If the API responds with an error
     * @throws NetworkException If there is a network error
     * @throws SdkException For other SDK errors
     */
    public function verifyToken(string $token): array
    {
        if (empty($token)) {
            throw new SdkException('Token cannot be empty');
        }

        $response = $this->httpClient->get('/api/v1/queue/verify', ['token' => $token]);

        if (!isset($response['success']) || $response['success'] !== true) {
            $errorCode = $response['error_code'] ?? null;
            $message = $response['message'] ?? 'Error verifying the token';
            throw new ApiException($message, 0, null, $errorCode, $response);
        }

        return $response['data'] ?? [];
    }

    /**
     * Checks if a token is valid.
     *
     * @param string $token Token to verify
     * @return bool True if the token is valid, false otherwise
     */
    public function isTokenValid(string $token): bool
    {
        try {
            $this->verifyToken($token);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Gets the finished line details for a token.
     *
     * @param string $token Token to verify
     * @return array|null Finished line details or null if the token is not valid
     */
    public function getFinishedLineDetails(string $token): ?array
    {
        try {
            $data = $this->verifyToken($token);
            return $data['finished_line'] ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
