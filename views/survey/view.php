<?php
$question=$params['question'];
$answers=$params['answers'];
?>
<h3 class="text-center mt-3">View survey</h3>
<div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/survey/cabinet">Survey List</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
    </nav>
</div>
<div class="col-md-12 col-lg-10 col-xl-8 mx-auto bg-body-tertiary p-4 rounded">
    <div class="container question">

        <div class="col-sm-12 col-lg-12">
            <h3 class="text-center mt-3">Question</h3>
        </div>
        <div class="row border p-3">
            <div class="col-sm-12 col-lg-8">
                <h5>Text</h5>
                <div class="text-break"><?php echo nl2br($question->text) ?></div>
            </div>
            <div class="col-sm-12 col-lg-2">
                <h5>Status</h5>
                <div><?php echo \models\Question::STATUSES[$question->status] ?></div>
            </div>
            <div class="col-sm-12 col-lg-2 mt-3">
                <a href="/survey/update?id=<?php echo $question->id ?>">
                    <button class="btn btn-primary">Edit</button>
                </a>
            </div>
        </div>
    </div>
    <div class="container answers">

        <div class="col-sm-12 col-lg-12">
            <h3 class="text-center mt-3">Answers</h3>
        </div>
        <div class='row border p-3'>
            <div class="col-sm-3 col-lg-2"><h5>Number</h5></div>
            <div class="col-sm-6 col-lg-7"><h5>Text</h5></div>
            <div class="col-sm-3 col-lg-3"><h5>Votes Number</h5></div>
        </div>
        <?php foreach ($answers as $i=>$answer): ?>
            <div class='row border p-3'>
                <div class="col-sm-3 col-lg-2"><?php echo $i+1 ?></div>
                <div class="col-sm-6 col-lg-7 text-break"><?php echo nl2br($answer->text) ?></div>
                <div class="col-sm-3 col-lg-3"><?php echo $answer->votes_number ?></div>
            </div>
        <?php endforeach; ?>

    </div>
</div>
