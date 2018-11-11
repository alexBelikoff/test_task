<?php
/**
 * Created by PhpStorm.
 * User: Beluha
 * Date: 11.11.2018
 * Time: 20:56
 */

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

class ApiShortenerController extends FOSRestController
{
    /**
     * @Post("/generate", name="api_generate_short_url", options={ "method_prefix" = false })
     * @Annotations\RequestParam(name="url", description="Урл")
     * @SWG\Response(
     *     response=200,
     *     description="Генерирует короткий URL-адрес на основе оригинального",
     *
     * )
     * @SWG\Tag(name="Генерация")
     *
     * @return $View
     */
    public function generateShortUlrAction(Request $request)
    {
        $view = View::create();
        $originalUrl = $request->request->get('url');
        if (!filter_var($originalUrl, FILTER_VALIDATE_URL, ['flags' => [FILTER_FLAG_PATH_REQUIRED]])) {
            return $view->setData(['message' => 'Введен некорректный  урл'])->setStatusCode(400);
        }
        $shortener = $this->get('test_task.shortener');
        return $view->setData(['url' => rawurlencode($shortener->makeShortUrl($originalUrl))])->setStatusCode(200);
    }
}