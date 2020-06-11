<?php

use JasperFW\DataAccess\MySQL;

return [
    'dbc' => new MySQL(
        [
            'username' => 'colmgr',
            'password' => 'lxeh6oyfpylezg7o',
            'server' => 'db-mysql-nyc1-18194-do-user-2414580-0.db.ondigitalocean.com:25060',
            'dbname' => 'collectionManager',
            'options' => [
                //PDO::MYSQL_ATTR_SSL_KEY => _ROOT_PATH_ . '/mysql-ssl/client-key.pem',
                //PDO::MYSQL_ATTR_SSL_CERT => _ROOT_PATH_ . '/mysql-ssl/client-cert.pem',
                PDO::MYSQL_ATTR_SSL_CA => _ROOT_PATH_ . '/mysql-ssl/ca-certificate.crt',
            ],
        ]
    ),
];