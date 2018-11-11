<?php
/**
 * Created by PhpStorm.
 * User: Beluha
 * Date: 11.11.2018
 * Time: 17:41
 */

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\ShortenedUrl;


class Shortener
{
    private static $chars = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '0',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
    ];
    private $em;
    private $host;
    private $rep;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->host = $requestStack->getCurrentRequest()->getHost();
        $this->rep = $this->em->getRepository(ShortenedUrl::class);
    }

    /**
     * @param int $id
     * @return string
     * @throws \Exception
     */
    private function createShortPath(int $id): string
    {
        $shortUrl = '';
        $charsCount = count(self::$chars);
        while ($id > $charsCount - 1) {
            $offset = fmod($id, $charsCount);
            if(!is_int($offset)){
                throw new \Exception('Что-то пошло не так');
            }
            $shortUrl = self::$chars[(int)$offset].$shortUrl;
            $id = floor($id / $charsCount);
        }

        return self::$chars[$id].$shortUrl;
    }

    /**
     * @param string $url
     * @return ShortenedUrl|null
     */
    private function getShortUrl(string $url):?ShortenedUrl
    {
        return $this->rep->findOneBy(['originalUrl' => $url]);

    }

    /**
     * @param $url
     * @return ShortenedUrl
     */
    private function addShortenedUrl($url):ShortenedUrl
    {
        $shortenedUrl = new ShortenedUrl();
        $shortenedUrl->setOriginalUrl($url);
        $this->em->persist($shortenedUrl);
        $this->em->flush();
        return $shortenedUrl;
    }

    /**
     * @param string $url
     * @return string
     * @throws \Exception
     */
    public function makeShortUrl(string $url):string
    {
        $shortenedUrl = $this->getShortUrl($url);
        if(!$shortenedUrl){
            $shortenedUrl = $this->addShortenedUrl($url);
        }
        if(!$shortenedUrl->getShortenedUrl()){
            $s = $this->host . '/' . $this->createShortPath($shortenedUrl->getId());
            $shortenedUrl->setShortenedUrl($s);
            $this->em->persist($shortenedUrl);
            $this->em->flush();
        }
        return $shortenedUrl->getShortenedUrl();
    }

}