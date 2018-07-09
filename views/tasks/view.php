<a href="/tasks" class="btn btn-primary">Back</a>
<hr />
<div class="row">
    <div class="col"></div>
    <div class="col-6">
        <h4>Details of task: <?=$task->id?></h4>
        <hr />
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td scope="row"><b>Username</b></td>
                <td><div id="username-view"><?=$task->username?></div></td>
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td><div id="email-view"><?=$task->email?></div></td>
            </tr>
            <tr>
                <td><b>Image</b></td>
                <td>
                    <?php
                    $imagePath = str_replace(PUBLIC_PATH, "", MEDIA_PATH . DIRECTORY_SEPARATOR .  $task->image)?>
                    <div id="image-view">
                        <img src="<?=$imagePath?>" />
                    </div>
                </td>
            </tr>
            <tr>
                <td><b>Content</b></td>
                <td><div id="content-view"><?=$task->content?></div></td>
            </tr>
            <tr>
                <td><b>Status</b></td>
                <td><div id="status-view"><?=\models\Task::getStatusLabel($task->status)?></div></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col"></div>
</div>