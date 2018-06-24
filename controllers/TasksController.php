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
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $tasks = new Task();
        $limit = 3;
        $offset = App::getInstance()->getRequest()->get('page') ? App::getInstance()->getRequest()->get('page') : 1;
        $taskResults = $tasks->search($limit, ($offset - 1) * $limit);
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
                    $this->redirect("/tasks/index");
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

        if (App::getInstance()->getAuthUser()->isGuest()) {
            return $this->redirect("/main/login");
        }

        $id = filter_var($this->getRequest()->get('id'), FILTER_SANITIZE_NUMBER_INT);

        if (!$id) {
            echo "id param required";
            http_response_code(404);
            die();
        }

        $task = new Task();
        $data = $this->findModel($task, $id);
        $task->id = $id;
        $task->load((array)$data);
        if ($this->getRequest()->isPost() && $task->load($this->getRequest()->post())) {
            if ($task->save()) {
                Session::getInstance()->setFlash('success', 'row updated successful');
                $this->redirect("/tasks/index");
            }
        }

        $this->render('tasks/form', ['task' => $task]);
    }

    protected function findModel($task, $id)
    {
        $data = $task->findByIdentity($id);
        if (!$data) {
            echo "Record not found";
            http_response_code(404);
            die();
        }
        return $data;
    }

    public function actionView()
    {
        $id = filter_var($this->getRequest()->get('id'), FILTER_SANITIZE_NUMBER_INT);

        if (!$id) {
            echo "id param required";
            http_response_code(404);
            die();
        }

        $task = new Task();
        $data = $this->findModel($task, $id);

        $task->load((array)$data);

        $this->render("tasks/view", ['task' => $task]);
    }

}