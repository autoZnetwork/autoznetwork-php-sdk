<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Syndications\CreateSyndicationRequest;
use AutozNetwork\Requests\Syndications\DeleteSyndicationRequest;
use AutozNetwork\Requests\Syndications\GetSyndicationRequest;
use AutozNetwork\Requests\Syndications\ListSyndicationsRequest;
use Saloon\Http\Response;

class SyndicationResource extends BaseResource
{
    public function all(): Response
    {
        return $this->connector->send(new ListSyndicationsRequest())->json();
    }

    public function get(int $id): Response
    {
        return $this->connector->send(new GetSyndicationRequest($id))->json();
    }

    public function create(array $data): Response
    {
        return $this->connector->send(new CreateSyndicationRequest($data))->json();
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(new DeleteSyndicationRequest($id))->json();
    }
}
