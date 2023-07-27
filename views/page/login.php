<form action="/page/login" method="get">
    <input type="hidden" name="csrf_token" value="<?php echo $params['csrf_token'] ?>">
    <div class="container">
        <h3 class="text-center m-5">Login</h3>
        <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12 col-lg-10 col-xl-8 mx-auto bg-body-tertiary p-4 rounded">
            <div class="col-12">
                <?php if (isset($params['error'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $params['error'] ?></div>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <label for="User[email]" class="form-label">Email</label>
                <input type="text" name="User[email]" class="form-control">
            </div>
            <div class="col-12">
                <label for="User[password]" class="form-label">Password</label>
                <input type="password" name="User[password]" class="form-control">
            </div>
            <div class="col-12 mt-3">
                <button class="btn btn-primary" type="submit">Login</button>
            </div>
        </div>
</form>
