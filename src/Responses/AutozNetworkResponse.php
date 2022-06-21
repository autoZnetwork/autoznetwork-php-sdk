<?php

namespace AutozNetwork\AutozNetwork\Responses;

use Sammyjo20\Saloon\Http\SaloonResponse;
use AutozNetwork\AutozNetwork\Exceptions\AutozNetworkRequestException;

class AutozNetworkResponse extends SaloonResponse
{
    /**
     * Create an exception if a server or client error occurred.
     *
     * @return AutozNetworkRequestException
     */
    public function toException(): AutozNetworkRequestException
    {
        if ($this->failed()) {
            $body = $this->response?->getBody()?->getContents();

            return new AutozNetworkRequestException($this, $body, 0, $this->getGuzzleException());
        }
    }
}
