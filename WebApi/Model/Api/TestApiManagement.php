<?php

namespace SRTechnologies\WebApi\Model\Api;

class TestApiManagement implements \SRTechnologies\WebApi\Api\TestApiManagementInterface
{

    /**
     * get test Api data.
     *
     * @api
     *
     * @param 
     *
     * @return \SRTechnologies\WebApi\Api\TestApiManagementInterface
     */
    public function getApiData()
    {
        $abc = ['multi'=>['FirstName'=>' Shubham','Lastname'=>'dudhane', 'Address'=>'Pune'] ]; 
        return $abc; 
    }
}

// php bin/magento setup:install –base-url="http://localhost/srtech/" –db-host="localhost" –db-name="srtech″ –db-user="root" –admin-firstname="admin" –admin-lastname="admin" –admin-email="admin@admin.com" –admin-user="admin" –admin-password="admin123″ –language="en_US" –currency="USD" –use-rewrites="1″ –backend-frontname="admin"
// php bin/magento setup:install --base-url="http://localhost/srtech" --db-host="localhost" --db-name="srtech" --db-user="root" --db-password="" --admin-firstname="admin" --admin-lastname="admin" --admin-email="admin@admin.com" --admin-user="admin" --admin-password="admin123" --use-rewrites="1" --backend-frontname="admin"

 // composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition srtech
