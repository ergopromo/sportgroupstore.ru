<?php

require_once('Requests.php');
use Sotbit\Origami\Helper\Config;

class InstagramController
{
    private static $accessToken;
    public function __construct() {
        self::$accessToken = Config::get('ACCESS_TOKEN');
    }

    private static function getMediaCtx() {
        $query = [
            'fields' => 'id,caption',
            'access_token' => self::$accessToken
        ];

        return CurlRequests::sendGetCurlRequest('/me/media', $query)->data ?: [];
    }

    public function getMediaPosts($limit) {
        $mediaPosts = [];
        $query = [
            'fields' => 'id,media_type,media_url,username,timestamp',
            'access_token' => self::$accessToken
        ];
        $mediaCtx = self::getMediaCtx();
        foreach(array_slice($mediaCtx, 0, $limit) as $postId) {
            $response = CurlRequests::sendGetCurlRequest('/'. $postId->id, $query);
            $mediaPosts[] = [
                "id" => $postId->id,
                "caption" => (SITE_CHARSET == "windows-1251") ? iconv('utf-8', 'windows-1251', $postId->caption) : $postId->caption,
                "media_url" => $response->media_url,
                "username" => $response->username
            ];
        }

        return $mediaPosts;
    }
}
