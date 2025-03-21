<?php

namespace VirtualQueue\TokenVerifier\Exception;

/**
 * Exception thrown when there is an error in the API response.
 */
class ApiException extends SdkException
{
    /**
     * @var int|null
     */
    protected $errorCode;

    /**
     * @var array
     */
    protected $errorData;

    /**
     * Constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @param int|null $errorCode
     * @param array $errorData
     */
    public function __construct(string $message, int $code = 0, \Throwable $previous = null, ?int $errorCode = null, array $errorData = [])
    {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
        $this->errorData = $errorData;
    }

    /**
     * Gets the API error code.
     *
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * Gets the additional error data.
     *
     * @return array
     */
    public function getErrorData(): array
    {
        return $this->errorData;
    }
}