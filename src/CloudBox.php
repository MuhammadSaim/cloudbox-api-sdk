<?php

namespace MuhammadSaim;

use GuzzleHttp\Client;

class CloudBox {

    /**
     * API Token of the CloudBox API
     *
     * @var string
     */
    private string $api_token;

    /**
     * Base URI of the API
     *
     * @var string
     */
    private string $base_url;

    /**
     * Guzzle client
     *
     * @var Client
     */
    private Client $client;

    /**
     * Headers for the each requests like authorization or accept
     *
     * @var array
     */
    private array $request_headers;

    /**
     * Simple constructor to initialize values
     *
     * @param string $token
     * @param string $base_url
     */
    public function __construct( string $token, string $base_url = null ) {
        $this->api_token = $token;
        $this->base_url = $base_url ?? "http://media-manager.test/api/";
        $this->request_headers = [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $this->api_token,
            'Content-type'  => 'application/json',
        ];
        $this->client = new Client( [
            'verify'   => __DIR__ . "/../cacert.pem",
            'base_uri' => $this->base_url,
            'headers'  => $this->request_headers,
        ] );
    }

    /**
     * return all the albums for the user
     *
     * @param int $page
     * @param int $parent_id
     * @return array
     */
    public function albums( int $page = 1, int $parent_id = null ): array{
        $payload = [];
        try {
            ( null === $parent_id ) ? $payload['page'] = $page : $payload = ['page' => $page, 'parent_id' => $parent_id];
            $response = $this->client->request( 'GET', 'albums', [
                "json" => $payload,
            ] );
            if ( $response->getStatusCode() === 200 ) {
                return json_decode( $response->getBody()->getContents(), true );
            } else {
                throw new \Exception( "Bad Request " . $response->getStatusCode() );
            }
        } catch ( \Exception$e ) {
            throw new \Exception( $e->getMessage() );
        }
    }

    /**
     * Create an album just pass the name.
     * If you want to create sub folder or album just pass
     * the parent_id as the 2nd argument.
     *
     * @param string $album_name
     * @param int $parent_id
     * @return array
     */
    public function createAlbum( string $album_name, int $parent_id = null ): array{
        $payload = [];
        try {
            ( null === $parent_id ) ? $payload['name'] = $album_name : $payload = ['name' => $album_name, 'parent_id' => $parent_id];
            $response = $this->client
                ->request( 'POST', 'albums/create', [
                    'json' => $payload,
                ] );
            if ( $response->getStatusCode() === 200 ) {
                return json_decode( $response->getBody()->getContents(), true );
            } else {
                throw new \Exception( "Bad Request " . $response->getStatusCode() );
            }
        } catch ( \Exception$e ) {
            throw new \Exception( $e->getMessage() );
        }
    }

    /**
     * update albums or floders
     *
     * @param string $name
     * @param integer $id
     * @return array
     */
    public function updateAlbum( string $name, int $id ): array{
        try {
            $response = $this->client->request( 'PUT', 'albums/update', [
                "json" => [
                    'name' => $name,
                    'id'   => $id,
                ],
            ] );
            if ( $response->getStatusCode() === 200 ) {
                return json_decode( $response->getBody()->getContents(), true );
            } else {
                throw new \Exception( "Bad Request " . $response->getStatusCode() );
            }
        } catch ( \Exception$e ) {
            throw new \Exception( $e->getMessage() );
        }
    }

    /**
     * delete album or folder
     *
     * @param integer $album_id
     * @return array
     */
    public function deleteAlbum( int $album_id ): array{
        try {
            $response = $this->client->request( 'DELETE', 'albums/delete', [
                "json" => [
                    'id' => $album_id,
                ],
            ] );
            if ( $response->getStatusCode() === 200 ) {
                return json_decode( $response->getBody()->getContents(), true );
            } else {
                throw new \Exception( "Bad Request " . $response->getStatusCode() );
            }
        } catch ( \Exception$e ) {
            throw new \Exception( $e->getMessage() );
        }
    }

    /**
     * list all the files in the album or folder
     *
     * @param integer $album_id
     * @return array
     */
    public function files( int $album_id, int $page = 1 ) {
        try {
            $response = $this->client->request( 'GET', 'files', [
                "json" => [
                    'album_id' => $album_id,
                    'page'     => $page,
                ],
            ] );
            if ( $response->getStatusCode() === 200 ) {
                return json_decode( $response->getBody()->getContents(), true );
            } else {
                throw new \Exception( "Bad Request " . $response->getStatusCode() );
            }
        } catch ( \Exception$e ) {
            throw new \Exception( $e->getMessage() );
        }
    }

    /**
     * upload image to the album or folder
     *
     * @param string $image
     * @param integer $album_id
     * @param integer $width
     * @param integer $height
     * @return array
     */
    public function imageUpload(
        string $image,
        int $album_id,
        int $width = null,
        int $height = null
    ) {
        try {
            $payload = [
                [
                    'name'     => 'image',
                    'contents' => fopen( $image, 'r' ),
                    'filename' => basename( $image ),
                ],
                [
                    'name'     => 'album_id',
                    'contents' => $album_id,
                ],
            ];
            if ( !empty( $width ) ) {
                array_push( $payload, [
                    'name'     => 'width',
                    'contents' => $width,
                ] );
                if ( !empty( $height ) ) {
                    array_push( $payload, [
                        'name'     => 'height',
                        'contents' => $height,
                    ] );
                }
            }
            $response = $this->client->request( 'POST', 'upload/image', [
                'multipart' => $payload,
            ] );
            if ( $response->getStatusCode() === 200 ) {
                return json_decode( $response->getBody()->getContents(), true );
            } else {
                throw new \Exception( "Bad Request " . $response->getStatusCode() );
            }
        } catch ( \Exception$e ) {
            throw new \Exception( $e->getMessage() );
        }
    }

    /**
     * upload video in album or folder
     *
     * @param string $video
     * @param integer $album_id
     * @return array
     */
    public function videoUpload( string $video, int $album_id ) {
        try {
            $payload = [
                [
                    'name'     => 'video',
                    'contents' => fopen( $video, 'r' ),
                    'filename' => basename( $video ),
                ],
                [
                    'name'     => 'album_id',
                    'contents' => $album_id,
                ],
            ];
            $response = $this->client->request( 'POST', 'upload/video', [
                'multipart' => $payload,
            ] );
            if ( $response->getStatusCode() === 200 ) {
                return json_decode( $response->getBody()->getContents(), true );
            } else {
                throw new \Exception( "Bad Request " . $response->getStatusCode() );
            }
        } catch ( \Exception$e ) {
            throw new \Exception( $e->getMessage() );
        }
    }

}