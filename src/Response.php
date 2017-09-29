<?php

namespace Blacktrue\CfdiValidator;

class Response
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Response constructor.
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCancelacion() : ?\DateTime
    {
        return empty($this->validator->getFechaCancelacion())
            ? null
            : new \DateTime($this->validator->getFechaCancelacion());
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->validator->getMessage();
    }

    /**
     * @return string
     */
    public function getEstate(): string
    {
        return $this->validator->getEstate();
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->validator->generateImage();
    }
}
