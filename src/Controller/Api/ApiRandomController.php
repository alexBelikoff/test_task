<?php
/**
 * Created by PhpStorm.
 * User: Beluha
 * Date: 11.11.2018
 * Time: 14:24
 */

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;


class ApiRandomController extends FOSRestController
{
    /**
     * @Post("/generate", name="api_add_random", options={ "method_prefix" = false })
     * @SWG\Response(
     *     response=200,
     *     description="Генерирует и возвращает случайное число",
     *     @Model(type=\App\Entity\Random::class)
     * )
     * @SWG\Tag(name="Генерация")
     *
     * @return $View
     */
    public function generateAction()
    {
        $view = View::create();
        $em = $this->getDoctrine()->getManager();
        $randomNumber = new \App\Entity\Random();
        $randService = $this->get('test_task.random_service');
        $randomNumber->setNumber($randService->getRandomNumber());
        $em->persist($randomNumber);
        $em->flush();

        return $view->setData($randomNumber)->setStatusCode(200);
    }

    /**
     * @Get("/retrieve/{id}", name="api_get_random",requirements={"id": "\d+"}, options={ "method_prefix" = false })
     * @SWG\Response(
     *     response=200,
     *     description="Возвращает сгенерированное ранее случайное число по его идентификатору",
     *     @Model(type=\App\Entity\Random::class)
     * )
     * @param int $id
     * @SWG\Tag(name="Генерация")
     *
     * @return $View
     */
    public function retrieveAction($id)
    {
        $view = View::create();
        $randRep = $this->getDoctrine()->getRepository(\App\Entity\Random::class);
        $random = $randRep->find($id);
        if (!$random) {
            return $view->setData(['message' => 'Запись с id '.$id.' не найдена'])->setStatusCode(404);
        }

        return $view->setData($random)->setStatusCode(200);
    }
}