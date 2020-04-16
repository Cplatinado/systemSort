<?php


namespace App\suport;


use CoffeeCode\Optimizer\Optimizer;

class Seo
{
    private $otimaizer;

    public function __construct()
    {

        $this->otimaizer = new Optimizer();
        $this->otimaizer->openGraph(
            env('APP_NAME'),
            'pt_BR',
            'article'
        )->publisher(
            env('CLIENT_SOCIAL_FACEBOOK_PAGE'),
            env('CLIENT_SOCIAL_FACEBOOK_AUTHOR')
        );
    }

    public function render(string $title, string $description, string $url, string $image, bool $follow = true )
    {
        return $this->otimaizer->optimize($title, $description, $url, $image, $follow)->render();
    }

}
