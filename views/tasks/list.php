<?php
    if (($message = \system\Session::getInstance()->getFlash('success'))) {
        echo \helpers\Alert::show('success', $message);
    }
?>

<h4>Tasks List</h4>
<hr/>
<?php $sort = \system\App::getInstance()->getRequest()->get('sort');
$pathInfo = \system\App::getInstance()->getRequest()->getPathInfo();
?>
<a href="/tasks/create" class="btn btn-primary">Add New</a>
<hr />
<table class="table">
    <thead>
    <tr>
        <th scope="col">
            <a href="<?php echo $pathInfo ?>?sort=<?= $sort === "-id" ? "id" : "-id" ?>">
                ID
            </a>
        </th>
        <th scope="col">
            <a href="<?php echo $pathInfo ?>?sort=<?= $sort === "-username" ? "username" : "-username" ?>">
                Username
            </a>
        </th>
        <th scope="col">
            <a href="<?php echo $pathInfo ?>?sort=<?= $sort === "-email" ? "email" : "-email" ?>">
                Email
            </a>
        </th>
        <th scope="col">Image</th>
        <th scope="col">Content</th>
        <th scope="col">
            <a href="<?php echo $pathInfo ?>?sort=<?= $sort === "-status" ? "status" : "-status" ?>">
                Status
            </a>
        </th>
        <th scope="col">Last Update</th>
        <th scope="col">Actions</th>
    </tr>
    <?php if (count($tasks)): ?>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td scope="row"><?php echo $task->id ?></td>
                <td><?php echo $task->username ?></td>
                <td><?php echo $task->email; ?></td>
                <td>
                    <?php $imagePath = str_replace(PUBLIC_PATH, "", MEDIA_PATH . DIRECTORY_SEPARATOR .  $task->image)?>
                    <a href="<?php echo $imagePath?>" target="_blank">
                        <?php echo  $task->image ?>
                    </a>
                </td>
                <td><?php echo $task->content; ?></td>
                <td><?php echo \models\Task::getStatusLabel($task->status); ?></td>
                <td><?php echo @date("Y.m.d H:i:s", $task->updated_at)?></td>
                <td>
                    <a href="/tasks/view?id=<?=$task->id?>">View</a>
                    <?php if (!\system\App::getInstance()->getAuthUser()->isGuest()):?>
                        <a href="/tasks/update?id=<?=$task->id?>">Update</a>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td scope="row" colspan="6"><?php echo "There is no items found" ?></td>
        </tr>
    <?php endif ?>
    </thead>
</table>
<?php echo $paginator->render(); ?>