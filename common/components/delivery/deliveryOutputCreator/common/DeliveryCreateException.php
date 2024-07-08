<?php


namespace common\components\delivery\deliveryOutputCreator\common;


use Throwable;

class DeliveryCreateException extends \Exception
{
    /**
     * @var string|null
     */
    private $messageForUser;

    /**
     * @inheritDoc
     */
    public function __construct($message = "", $messageForUser = null, $code = 0, Throwable $previous = null)
    {
        $this->messageForUser = $messageForUser;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string|null
     */
    public function getMessageForUser(): ?string
    {
        return $this->messageForUser;
    }
}