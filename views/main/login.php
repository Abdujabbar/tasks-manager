<div class="row">
    <div class="col"></div>
    <div class="col-6">
        <h4>Login Form</h4>
        <?php
        if(($message = \system\Session::getInstance()->getFlash('danger'))) {
            echo \components\Alert::show('danger', $message);
        }
        ?>
        <form method="post" action="">
            <div class="form-group row">
                <label for="login" class="col-sm-2 col-form-label">Login</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="login" name="login" value="<?=$login?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" value="<?=$password?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <div class="col"></div>
</div>