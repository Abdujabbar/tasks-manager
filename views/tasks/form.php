<?php
/**
 * @var $task \models\Task
 */
?>
<div class="row">
    <div class="col"></div>
    <div class="col-6">
        <h4><?php echo $task->id ? "Update task" : "Create task" ?></h4>
        <hr/>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?= $task->username ?>">
                    <?php
                    if ($error = $task->getErrors('username'))
                        echo \helpers\Alert::show('danger', $error);
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?= $task->email ?>">
                    <?php
                    if ($error = $task->getErrors('email'))
                        echo \helpers\Alert::show('danger', $error);
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <?php if($task->image):?>
                        <input type="hidden" name="image" value="<?=$task->image;?>">
                    <?php endif;?>
                    <input type="file" class="form-control" id="image" name="image"
                           accept="image/jpeg,image/png,image/gif" />
                    <?php
                    if ($error = $task->getErrors('image'))
                        echo \helpers\Alert::show('danger', $error);
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="content" class="col-sm-2 col-form-label">Content</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="content" rows="3" name="content"><?php echo $task->content;?></textarea>
                    <?php
                    if ($error = $task->getErrors('content'))
                        echo \helpers\Alert::show('danger', $error);
                    ?>
                </div>
            </div>
            <?php if (!\system\App::getInstance()->getAuthUser()->isGuest() && $task->id): ?>
                <div class="form-group row">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status" name="status">
                            <?php foreach (\models\Task::getStatusList() as $key => $label): ?>
                                <option value="<?php echo $key ?>" <?=$key == $task->status ? "selected" : ""?>><?php echo $label ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php
                        if ($error = $task->getErrors('status'))
                            echo \helpers\Alert::show('danger', $error);
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Preview</button>
        </form>
    </div>
    <div class="col"></div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td scope="row"><b>Username</b></td>
                            <td><div id="username-view"></div></td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td><div id="email-view"></div></td>
                        </tr>
                        <tr>
                            <td><b>Image</b></td>
                            <td><div id="image-view"></div></td>
                        </tr>
                        <tr>
                            <td><b>Content</b></td>
                            <td><div id="content-view"></div></td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td><div id="status-view"></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>