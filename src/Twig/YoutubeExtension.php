<?php

namespace App\Twig;

use RicardoFiorani\Matcher\VideoServiceMatcher;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class YoutubeExtension extends AbstractExtension
{
    private $youtubeParser;

    /**
     * YoutubeExtension constructor.
     * @param $youtubeParser
     */
    public function __construct()
    {
        $this->youtubeParser = new videoServiceMatcher();
    }


    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            // new TwigFilter('miniature', [$this, 'miniature']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('video', [$this, 'video']),
            new TwigFunction('miniature', [$this, 'miniature']),
        ];
    }

    public function miniature($url){
        $video = $this->youtubeParser->parse($url);
        echo $video->getMediumThumbnail();
    }

    public function video($url){
        $video = $this->youtubeParser->parse($url);

        if ($video->isEmbeddable()) {
            echo $video->getEmbedCode(854, 480, true);
        }
    }
}
