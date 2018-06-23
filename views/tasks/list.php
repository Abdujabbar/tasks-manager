<h4>Tasks List</h4>
<hr />

<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">email</th>
            <th scope="col">Image</th>
            <th scope="col">Content</th>
            <th scope="col">Status</th>
        </tr>
        <?php if(count($tasks)):?>
        <?php foreach($tasks as $task):?>
        <tr>
            <td scope="row"><?php echo $task->id?></td>
            <td><?php echo $task->username?></td>
            <td><?php echo $task->email;?></td>
            <td><?php echo $task->image?></td>
            <td><?php echo $task->content;?></td>
            <td><?php echo $task->status;?></td>
        </tr>
        <?php endforeach;?>
        <?php else:?>
        <tr>
            <td  scope="row" colspan="6"><?php echo "There is no items found"?></td>
        </tr>
        <?php endif?>
    </thead>
</table>
<?php echo $paginator->render();?>