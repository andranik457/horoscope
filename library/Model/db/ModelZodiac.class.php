<?php

class CModelZodiac {

    /**
     * @var mixed|string|void
     */
    private $mongoHost = DB_MONGO_HOSTNAME_ZODIAC;

    /**
     * @var string
     */
    private $mongoDB = DB_MONGO_ZODIAC;

    /**
     * @var \MongoDB\Database|null
     */
    protected $db = null;

    /**
     * CModelZodiac constructor.
     */
    function __construct() {
        $host = json_decode( $this->mongoHost, JSON_OBJECT_AS_ARRAY );

        if ($host['params']) {
            $mongoClient = new MongoDB\Client( $host['host'], $host['params'] );
        }
        else {
            $mongoClient = new MongoDB\Client( $host['host'] );
        }

        $this->db = $mongoClient->selectDatabase( $this->mongoDB );
    }

    /**
     *
     */
    public function __destruct() {
        $this->db = null;
    }


}