<form action="/page/register" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?>">
    <div class="container">
        <h3 class="text-center m-5">Register</h3>
        <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Register</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12 col-lg-10 col-xl-8 mx-auto bg-body-tertiary p-4 rounded">
            <div class="col-12">
                <label for="User[email]" class="form-label">Email</label>
                <input type="text" name="User[email]" class="form-control">
                <?php if (isset($params['validErrors']['email'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo implode('<br/>',$params['validErrors']['email']) ?></div>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <label for="User[password]" class="form-label">Password</label>
                <input type="password" name="User[password]" class="form-control">
                <?php if (isset($params['validErrors']['password'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo implode('<br/>',$params['validErrors']['password']) ?></div>
                <?php endif; ?>
            </div>
            <div class="col-12 mt-3">
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
        </div>
</form>

