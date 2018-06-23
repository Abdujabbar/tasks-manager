<?php
/**
 * Created by PhpStorm.
 * User: abdujabbor
 * Date: 6/23/18
 * Time: 11:15 PM
 */

namespace controllers;


use helpers\Pagination;
use models\Task;
use system\App;
use system\Controller;
use system\Session;

class TasksController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $tasks = new Task();
        $limit = 3;
        $offset = App::getInstance()->getRequest()->get('page') ? App::getInstance()->getRequest()->get('page') : 1;
        $taskResults = $tasks->search($limit, $offset - 1);
        $pagination = new Pagination("/tasks/index", $taskResults['total'], $limit, 'page');
        $this->render('tasks/list', [
            'tasks' => $taskResults['items'],
            'paginator' => $pagination,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function actionCreate()
    {
        $task = new Task();

        if ($this->getRequest()->isPost() && $task->load($this->getRequest()->post())) {
            try {
                if ($task->save()) {
                    Session::getInstance()->setFlash('success', 'Item has been created successful');
                    $this->redirect("tasks/index");
                }

            } catch (\PDOException $e) {
                echo $e->getMessage();
                http_response_code(500);
                die();
            }
        }
        $this->render('tasks/form', ['task' => $task]);
    }

    public function actionUpdate()
    {

    }


}