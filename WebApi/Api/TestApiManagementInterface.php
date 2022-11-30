<?php

namespace SRTechnologies\WebApi\Api;

interface TestApiManagementInterface
{
    /**
     * get test Api data.
     *
     * @api
     *
     * @param int $id
     *
     * @return \SRTechnologies\WebApi\Api\TestApiManageMent
     */
    public function getApiData();
}