<html>
<head>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Task Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php if(\system\App::getInstance()->getAuthUser()->isGuest()):?>
                <li class="nav-item">
                    <a class="nav-link" href="/main/login">Login</span></a>
                </li>
                <?php else:?>
                <li class="nav-item">
                    <a class="nav-link" href="/main/logout">Logout(<?=\system\App::getInstance()->getAuthUser()->getIdentity()->username?>)</span></a>
                </li>
                <?php endif;?>
            </ul>

        </div>
    </nav>
    <hr />
    <div class="content">
        <?php echo $content; ?>
    </div>
</div>
</body>
</html>