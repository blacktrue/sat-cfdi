<?php

namespace Blacktrue\CfdiValidator;

class Response
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Response constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCancelacion() : ?\DateTime
    {
        return empty($this->data['fechaCancelacion'])
            ? null
            : new \DateTime($this->data['fechaCancelacion']);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->data['message'];
    }

    /**
     * @return string
     */
    public function getEstate(): string
    {
        return $this->data['estate'];
    }
}
