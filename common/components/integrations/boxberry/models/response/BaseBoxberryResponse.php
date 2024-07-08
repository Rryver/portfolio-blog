<?php


namespace common\components\integrations\boxberry\models\response;


use common\components\integrations\common\CommonResponseObject;

class BaseBoxberryResponse extends CommonResponseObject
{
    /**
     * @var bool
     */
    private $error = false;

    /**
     * @var string|null
     */
    private $message;

    public function isSuccess(): bool
    {
        return (!$this->isError() && parent::isSuccess());
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->error;
    }

    /**
     * @param bool $error
     */
    public function setError(bool $error): void
    {
        $this->error = $error;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }


}