<?php

namespace App\Service;


class FtpService
{
    /**
     * @var array $ftpParameters
     */
    private $ftpParameters;

    private $server_ip;

    private $ftp_user_name;

    private $ftp_user_pass;

    private $connection;

    private $login;

    /**
     * FtpService constructor.
     * @param array $ftpParameters
     */
    public function __construct(array $ftpParameters)
    {
        $this->ftpParameters = $ftpParameters;

        $this->server_ip = $ftpParameters['server_ip'];
        $this->ftp_user_name = $ftpParameters['ftp_user_name'];
        $this->ftp_user_pass = $ftpParameters['ftp_user_pass'];

//        $this->connection = ftp_connect($this->server_ip);
    }

    public function connect()
    {
        return $this->connection = ftp_connect($this->server_ip);
    }

    public function sendFile()
    {
        return true;
    }
}
