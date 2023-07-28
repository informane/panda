<div class="container">
    <h3 class="text-center m-5">Welcome</h3>
    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto bg-body-tertiary p-4 rounded">
        <div class="col-12">
            This project is developed by Prysiazhniuk Roman as a test task for Panda Team.
        </div>
        <?php if(isset($_SESSION['login'])): ?>
            <div class="col-12 m-5">
                <div class="row">
                    <div class="col-3 text-center"></div>
                    <div class="col-4 text-center">
                        <a href='/survey/cabinet'><button class="btn-primary btn">Cabinet</button></a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-12">
                <h3 class="text-center m-5">Choose action</h3>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-3 text-center"></div>
                    <div class="col-3 text-center">
                        <a href='/page/login'><button class="btn-primary btn">Login</button></a>
                    </div>
                    <div class="col-3 text-center">
                        <a href='/page/register'><button class="btn-primary btn">Register</button></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>